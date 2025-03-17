<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\StudentProfile;
use App\Models\SocialAccount;
use App\Models\Waitlist;
use App\Models\AffiliateDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;





class SocialAuthController extends Controller
{
    /**
     * Redirect the user to the authentication page.
     */
    public function redirectToProvider(string $provider)
    {
        if (!in_array($provider, ['google', 'github', 'linkedin', 'microsoft'])) {
            return redirect()->route('login')->with('error', 'Invalid authentication provider.');
        }
        
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle provider callback.
     */
    public function handleProviderCallback(string $provider, Request $request)
    {
        if (!in_array($provider, ['google', 'github', 'linkedin', 'microsoft'])) {
            return redirect()->route('login')->with('error', 'Invalid authentication provider.');
        }
        
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            Log::error('Social login error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Unable to authenticate with ' . ucfirst($provider) . '. Please try again.');
        }
    
        // Start a transaction for the entire process
        \DB::beginTransaction();
        
        try {
            // Check if we already have a social account record
            $socialAccount = SocialAccount::where('provider_name', $provider)
                ->where('provider_id', $socialUser->getId())
                ->first();
            
            // If we have a social account, get the user
            if ($socialAccount) {
                $user = $socialAccount->user;
            } else {
                // If no social account exists, check if a user with this email exists
                $user = User::where('email', $socialUser->getEmail())->first();
                
                $name = $socialUser->getName();
                if (empty($name) && $provider === 'linkedin') {
                    // LinkedIn sometimes returns first/last name separately
                    $name = trim($socialUser->first_name . ' ' . $socialUser->last_name);
                }

                // If user doesn't exist, create a new one
                if (!$user) {
                    $user = User::create([
                        'name' => $name,
                        'email' => $socialUser->getEmail(),
                        'password' => bcrypt(Str::random(16)), // Random password as they won't use it
                        'email_verified_at' => now(), // Auto-verify since it's from a trusted source
                        'account_status' => 'active',
                    ]);
                    
                    // Default to student role
                    $studentRole = Role::where('name', 'student')->first();
                    $user->roles()->attach($studentRole->id, ['assigned_at' => now()]);
                    
                    // Create student profile
                    StudentProfile::create(['user_id' => $user->id]);
                    
                    // Check if user was on waitlist and mark as converted
                    $waitlistEntry = Waitlist::where('email', $user->email)->first();
                    if ($waitlistEntry) {
                        $waitlistEntry->update([
                            'is_invited' => true,
                            'converted_user_id' => $user->id
                        ]);
                        
                        // If they were referred, process the referral
                        if ($waitlistEntry->referral_code) {
                            $this->processReferral($user, $waitlistEntry->referral_code);
                        }
                    }
                }
                
                // Create a new social account entry for existing or new user
                $user->socialAccounts()->create([
                    'provider_name' => $provider,
                    'provider_id' => $socialUser->getId(),
                ]);
            }
            
            \DB::commit();
            
            // Log the user in
            Auth::login($user, true);
            
            return redirect()->intended(route('dashboard'));
            
        } catch (\Exception $e) {
            \DB::rollBack();
            Log::error('Social login/registration error: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'There was an error with your social login. Please try again.');
        }
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