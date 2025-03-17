<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\CompanyProfile;
use App\Models\AffiliateDetail;
use App\Models\Waitlist;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use App\Mail\VerifyEmail;
use App\Mail\ResetPasswordOtp;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Schema;
use App\Rules\StrongPassword;



class AuthController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request): \Illuminate\Http\RedirectResponse
    {
        $userData = [
            $request->name ?? '',
            $request->email ?? '',
        ];
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', new StrongPassword($userData)],
            'user_role' => ['required', 'in:student,company'],
            'terms' => ['required', 'accepted'],
        ]);
        
        // Use a database transaction to ensure data integrity
        try {
            return DB::transaction(function () use ($request, $validated) {
                // Create the user
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => $validated['password'], // Laravel 12 automatically hashes with 'password' => 'hashed' cast
                    'account_status' => 'active',
                ]);
                
                // Assign role
                $role = Role::where('name', $validated['user_role'])->firstOrFail();
                $user->roles()->attach($role->id, ['assigned_at' => now()]);
                
                // Create profile based on role
                if ($validated['user_role'] === 'student') {
                    StudentProfile::create(['user_id' => $user->id]);
                    
                    // If user came through referral, track it
                    if ($request->filled('referral_code')) {
                        $this->processReferral($user, $request->referral_code);
                    }
                    
                    // If user should be a seller or affiliate
                    if ($request->has('is_seller') && $request->is_seller == '1') {
                        $user->permissions()->attach(
                            \App\Models\Permission::where('name', 'can_sell')->firstOrFail()->id,
                            ['status' => 'active', 'granted_at' => now()]
                        );
                    }
                    
                    if ($request->has('is_affiliate') && $request->is_affiliate == '1') {
                        $user->permissions()->attach(
                            \App\Models\Permission::where('name', 'can_affiliate')->firstOrFail()->id,
                            ['status' => 'active', 'granted_at' => now()]
                        );
                        
                        // Create affiliate details
                        AffiliateDetail::create([
                            'user_id' => $user->id,
                            'affiliate_code' => $this->generateAffiliateCode($user),
                            'total_referrals' => 0
                        ]);
                    }
                } elseif ($validated['user_role'] === 'company') {
                    CompanyProfile::create([
                        'user_id' => $user->id,
                        'company_name' => $validated['name'], // Default to user name, can be updated later
                        'verification_status' => 'pending'
                    ]);
                }
                
                // Check if user was on waitlist and mark as converted
                $waitlistEntry = Waitlist::where('email', $user->email)->first();
                if ($waitlistEntry) {
                    $waitlistEntry->update([
                        'is_invited' => true,
                        'converted_user_id' => $user->id
                    ]);
                }
                
                // Generate verification token and send email using new signed URL approach
                $verificationUrl = URL::temporarySignedRoute(
                    'verification.verify',
                    now()->addMinutes(10),
                    [
                        'id' => $user->id,
                        'hash' => sha1($user->email)
                    ]
                );
                
                // Send verification email with the signed URL
                Mail::to($user->email)->send(new VerifyEmail($user, $verificationUrl));
                
                // Log the user in
                Auth::login($user);
                
                return redirect()->route('verification.notice');
            });
        } catch (\Throwable $e) {
            // Log the error
            Log::error('Registration failed: ' . $e->getMessage());
            
            // Return to registration page with error
            return back()
                ->withInput($request->except('password'))
                ->withErrors(['email' => 'Registration failed. Please try again.']);
        }
    }

    /**
     * Show login form
     */
    public function showLoginForm(Request $request)
    {
        // Get email from query parameter (if present from verification)
        $email = $request->query('email');
        
        return view('auth.login', [
            'prefillEmail' => $email
        ]);
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Check if email is verified
            if (!Auth::user()->email_verified_at) {
                return redirect()->route('verification.notice');
            }

            // Redirect to dashboard or intended URL
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->except('password'));
    }

    /**
     * Log the user out
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Show email verification notice
     */
    public function showVerificationNotice()
    {
        return view('auth.verify-email');
    }

    /**
     * Handle email verification
     */
    public function verifyEmail(Request $request, $id, $token)
    {
        $user = User::findOrFail($id);
        
        // Check if verification token is valid
        if (!$this->isValidVerificationToken($user, $token)) {
            return redirect()->route('verification.notice')
                ->with('error', 'Invalid verification link. Please request a new one.');
        }

        // Mark email as verified
        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
            $user->save();
        }

        return redirect()->route('dashboard')
            ->with('status', 'Your email has been verified successfully!');
    }

    /**
     * Resend verification email
     */
    public function resendVerificationEmail(Request $request)
    {
        if ($request->user()->email_verified_at) {
            return redirect()->route('dashboard');
        }

        $verificationToken = $this->generateVerificationToken($request->user());
        
        Mail::to($request->user()->email)->send(new VerifyEmail($request->user(), $verificationToken));

        return back()->with('resent', true);
    }


    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }
    

    
    /**
     * Show verify OTP form
     */
    public function showVerifyOtpForm(Request $request)
    {
        // Make sure email is provided in the request
        if (!$request->has('email')) {
            return redirect()->route('password.request')
                ->with('error', 'Email address is required.');
        }
        
        return view('auth.verify-otp', ['email' => $request->email]);
    }
    
    public function sendPasswordResetOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);
    
        $user = User::where('email', $request->email)->first();
        
        // Generate OTP
        $otp = $this->generateOtp();
        
        // Store OTP in password_reset_tokens table
        $resetData = [
            'token' => Hash::make($otp),
            'created_at' => now()
        ];
        
        // Check if we're using the old or new table name
        if (Schema::hasTable('password_reset_tokens')) {
            \DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                $resetData
            );
        } else {
            // Fall back to the password_resets table if it exists
            \DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                $resetData
            );
        }
        
        // Send OTP email
        Mail::to($request->email)->send(new ResetPasswordOtp($user, $otp));
    
        return redirect()->route('password.verify-otp-form', ['email' => $request->email])
            ->with('status', 'We have sent a password reset OTP to your email.');
    }
    
    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => ['required', 'string', 'size:6'],
        ]);
    
        // Determine which table to use
        $table = Schema::hasTable('password_reset_tokens') ? 'password_reset_tokens' : 'password_resets';
        
        // Get the record
        $passwordReset = \DB::table($table)->where('email', $request->email)->first();
        
        if (!$passwordReset || !Hash::check($request->otp, $passwordReset->token)) {
            return back()->with('error', 'Invalid OTP. Please try again.')
                ->withInput(['email' => $request->email]);
        }
    
        // Check if OTP is expired (valid for 15 minutes)
        if (Carbon::parse($passwordReset->created_at)->addMinutes(15)->isPast()) {
            return back()->with('error', 'OTP has expired. Please request a new one.')
                ->withInput(['email' => $request->email]);
        }
    
        // Generate password reset token
        $token = Str::random(60);
        
        // Update the token
        \DB::table($table)->where('email', $request->email)->update([
            'token' => $token
        ]);
    
        return redirect()->route('password.reset', ['token' => $token, 'email' => $request->email]);
    }
    
    
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);
    
        $user = User::where('email', $request->email)->first();
        
        // Generate new OTP
        $otp = $this->generateOtp();
        
        // Determine which table to use
        $table = Schema::hasTable('password_reset_tokens') ? 'password_reset_tokens' : 'password_resets';
        
        // Update OTP in the appropriate table
        \DB::table($table)->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($otp),
                'created_at' => now()
            ]
        );
        
        // Send OTP email
        Mail::to($request->email)->send(new ResetPasswordOtp($user, $otp));
    
        return back()->with('status', 'We have sent a new OTP to your email.')
            ->withInput(['email' => $request->email]);
    }
    
    /**
     * Show reset password form
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        // Ensure we have both token and email
        if (!$request->has('email')) {
            return redirect()->route('password.request')
                ->with('error', 'Invalid password reset link.');
        }
        
        return view('auth.reset-password', [
            'token' => $token, 
            'email' => $request->email
        ]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        
        // Get user data to check against password
        $userData = [
            $user->name ?? '',
            $user->email ?? '',
        ];
        
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required', 'confirmed', new StrongPassword($userData)],
        ]);

        $passwordReset = PasswordReset::where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Invalid token.']);
        }

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the token
        $passwordReset->delete();

        // Auto-login user
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('status', 'Your password has been reset successfully!');
    }

    /**
     * Generate 6-digit OTP
     */
    private function generateOtp()
    {
        return str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Generate verification token for a user
     */
    private function generateVerificationToken($user)
    {
        $token = hash_hmac('sha256', Str::random(40), config('app.key'));
        
        // Store token in user's remember_token temporarily
        $user->remember_token = $token;
        $user->save();
        
        return $token;
    }

    /**
     * Check if verification token is valid
     */
    private function isValidVerificationToken($user, $token)
    {
        return $user->remember_token === $token;
    }

    /**
     * Generate unique affiliate code
     */
    private function generateAffiliateCode($user)
    {
        $baseCode = strtoupper(substr(str_replace(' ', '', $user->name), 0, 3) . substr(md5($user->email), 0, 5));
        
        // Check if code already exists
        $existingCode = AffiliateDetail::where('affiliate_code', $baseCode)->exists();
        
        if ($existingCode) {
            $baseCode .= rand(10, 99);
        }
        
        return $baseCode;
    }

    /**
     * Process referral if user was referred
     */
    private function processReferral($user, $referralCode)
    {
        $affiliateDetail = AffiliateDetail::where('affiliate_code', $referralCode)->first();
        
        if ($affiliateDetail) {
            // Increment referral count
            $affiliateDetail->increment('total_referrals');
            
            // Here you would also add code to handle any rewards or commissions
            // for the referrer, depending on your business logic
        }
    }
}