<?php

// 1. routes/web.php - Laravel 12 uses a cleaner syntax for routes

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\WaitlistController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Mail;

// Landing page with waitlist
Route::view('/', 'landing')->name('home');

// Waitlist routes
Route::post('/waitlist', [WaitlistController::class, 'store'])->name('waitlist.store');

// Authentication routes
Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Registration routes
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/auth/{provider}', [SocialAuthController::class, 'redirectToProvider'])->where('provider', 'google|github|linkedin|microsoft')->name('social.login');
    Route::get('/auth/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback'])->where('provider', 'google|github|linkedin|microsoft')->name('social.callback');   
   
    // Password reset routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetOtp'])->name('password.email');
    Route::get('/verify-otp', [AuthController::class, 'showVerifyOtpForm'])->name('password.verify-otp-form');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('password.verify-otp');
    Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('password.resend-otp');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Email verification
    Route::get('/email/verify', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])->middleware(['throttle:6,1'])->name('verification.resend');
        
    // Protected routes that also require email verification
    Route::middleware('verified')->group(function () {
        // Dashboard (placeholder for now)
        Route::view('/dashboard', 'dashboard')->name('dashboard');
        
        // Affiliate and referral link management
        Route::get('/referral-link', [WaitlistController::class, 'getReferralLink'])->name('referral.link');
    });
});
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['signed'])->name('verification.verify');
  

// Static pages
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/privacy', 'pages.privacy')->name('privacy');

// Admin routes (protected by admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Waitlist statistics
    Route::get('/waitlist-stats', [WaitlistController::class, 'stats'])->name('admin.waitlist-stats');
});


Route::get('/test-email', function () {
    // Only enable this route during testing, remove in production
    try {
        Mail::raw('Testing email configuration', function($message) {
            $message->to('sagarinnovate@gmail.com')
                  ->subject('SkillBolt.dev Email Test');
        });
        
        return 'Email sent successfully!';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});