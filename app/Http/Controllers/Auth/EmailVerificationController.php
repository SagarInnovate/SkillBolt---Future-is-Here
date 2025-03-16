<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use App\Mail\VerifyEmail;
use App\Models\User;
use Carbon\Carbon;

class EmailVerificationController extends Controller
{
    /**
     * Show the verification notice.
     */
    public function notice()
    {
        // Check whether we need to disable the resend button
        $user = auth()->user();
        $cooldownEnds = $this->getEmailCooldownTime($user);
        $remainingTime = $cooldownEnds ? now()->diffInSeconds($cooldownEnds, false) : 0;
        
        return view('auth.verify-email', [
            'cooldownActive' => $remainingTime > 0,
            'remainingTime' => $remainingTime,
            'attemptsLeft' => $this->getAttemptsLeft($user),
        ]);
    }

    /**
     * Send a new verification email.
     */
    public function resend(Request $request)
    {
        $user = $request->user();
        
        // Check if user is already verified
        if ($user->email_verified_at) {
            return redirect()->route('dashboard')->with('status', 'Your email has already been verified.');
        }
        
        // Check if user is suspended
        if ($user->account_status === 'suspended') {
            return back()->with('error', 'Your account has been suspended due to suspicious activity. Please contact support.');
        }
        
        // Check cooldown period
        $cooldownEnds = $this->getEmailCooldownTime($user);
        if ($cooldownEnds && now()->lt($cooldownEnds)) {
            $remainingSeconds = now()->diffInSeconds($cooldownEnds);
            return back()->with('error', "Please wait {$remainingSeconds} seconds before requesting another verification email.");
        }
        
        // Check attempt limits
        $attemptsLeft = $this->getAttemptsLeft($user);
        if ($attemptsLeft <= 0) {
            // Suspend account after too many attempts
            $user->update(['account_status' => 'suspended']);
            
            return back()->with('error', 'Your account has been temporarily suspended due to too many verification attempts. Please contact support.');
        }
        
        // Generate verification URL (valid for 10 minutes)
        $verificationUrl = $this->generateVerificationUrl($user);
        
        // Send the email
        Mail::to($user->email)->send(new VerifyEmail($user, $verificationUrl));
        
        // Set new cooldown period based on attempts
        $this->setEmailCooldown($user);
        
        // Decrement attempts left
        $this->decrementAttemptsLeft($user);
        
        return back()->with('resent', true);
    }

    /**
     * Mark the user's email as verified.
     */
    public function verify(Request $request, $id)
    {
        // Validate the URL signature
        if (!$request->hasValidSignature()) {
            return redirect()->route('verification.notice')
                ->with('error', 'The verification link is invalid or has expired.');
        }
        
        $user = User::findOrFail($id);
        
        // Check if already verified
        if ($user->email_verified_at) {
            return redirect()->route('dashboard')
                ->with('status', 'Your email has already been verified.');
        }
        
        // Verify the user
        $user->email_verified_at = now();
        $user->save();
        
        // Reset attempts and cooldown
        $this->resetVerificationLimits($user);
        
        return redirect()->route('dashboard')
            ->with('status', 'Your email has been verified successfully!');
    }

    /**
     * Generate a secure, signed verification URL.
     */
    private function generateVerificationUrl(User $user): string
    {
        // Generate a secure, signed URL valid for 10 minutes
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(10),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );
    }

    /**
     * Get the current email cooldown time from cache.
     */
    private function getEmailCooldownTime(User $user): ?Carbon
    {
        $cooldownEnd = Cache::get("email_verification_cooldown:{$user->id}");
        return $cooldownEnd ? Carbon::parse($cooldownEnd) : null;
    }

    /**
     * Set a cooldown period for sending verification emails.
     * The cooldown increases with each attempt.
     */
    private function setEmailCooldown(User $user): void
    {
        $attempts = 5 - $this->getAttemptsLeft($user);
        
        // Increase cooldown with each attempt: 30s, 2m, 5m, 15m
        $cooldownSeconds = match($attempts) {
            0 => 30,
            1 => 120,
            2 => 300,
            3 => 900,
            default => 1800 // 30 minutes for subsequent attempts
        };
        
        $cooldownEnds = now()->addSeconds($cooldownSeconds);
        Cache::put("email_verification_cooldown:{$user->id}", $cooldownEnds, $cooldownSeconds);
    }

    /**
     * Get the number of verification attempts left for a user.
     */
    private function getAttemptsLeft(User $user): int
    {
        $attempts = Cache::get("email_verification_attempts:{$user->id}", 5);
        return max(0, $attempts);
    }

    /**
     * Decrement the number of attempts left.
     */
    private function decrementAttemptsLeft(User $user): void
    {
        $attemptsLeft = $this->getAttemptsLeft($user);
        
        if ($attemptsLeft > 0) {
            // Store for 24 hours
            Cache::put("email_verification_attempts:{$user->id}", $attemptsLeft - 1, 60 * 24 * 60);
        }
    }

    /**
     * Reset verification limits after successful verification.
     */
    private function resetVerificationLimits(User $user): void
    {
        Cache::forget("email_verification_cooldown:{$user->id}");
        Cache::forget("email_verification_attempts:{$user->id}");
    }
}