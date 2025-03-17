<?php

// 1. routes/web.php - Laravel 12 uses a cleaner syntax for routes

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\WaitlistController;
use App\Http\Controllers\Auth\SocialAuthController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\AffiliateController;
use App\Http\Controllers\Admin\AdminAffiliateController;
use App\Services\AffiliateService;
use Illuminate\Http\Request;





// Static pages
Route::view('/', 'landing')->name('home');
Route::post('/waitlist', [WaitlistController::class, 'store'])->name('waitlist.store');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/privacy', 'pages.privacy')->name('privacy');

// Tracking route - not protected to allow click tracking
Route::get('/track/ref', function (Request $request) {
    if ($request->has('code')) {
        $referralCode = $request->code;
        
        // Store referral code in session for later use during registration
        session(['referral_code' => $referralCode]);
        
        // Track the click using the service
        app(AffiliateService::class)->trackReferralClick($request, $referralCode);
    }
    
    // Redirect to homepage
    return redirect('/');
})->name('track.referral');






//user routes 
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['signed'])->name('verification.verify');

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

Route::middleware(['auth', 'verified'])->prefix('affiliate')->name('affiliate.')->group(function () {
    Route::get('/dashboard', [AffiliateController::class, 'dashboard'])->name('dashboard');
    Route::get('/referrals', [AffiliateController::class, 'referrals'])->name('referrals');
    Route::get('/commissions', [AffiliateController::class, 'commissions'])->name('commissions');
    Route::get('/leaderboard', [AffiliateController::class, 'leaderboard'])->name('leaderboard');
    Route::get('/payouts', [AffiliateController::class, 'payouts'])->name('payouts');
    Route::post('/request-payout', [AffiliateController::class, 'requestPayout'])->name('request-payout');
    Route::post('/generate-qr-code', [AffiliateController::class, 'generateQrCode'])->name('generate-qr-code');
    Route::get('/join', [AffiliateController::class, 'showJoinForm'])->name('join');
    Route::post('/join', [AffiliateController::class, 'processJoin'])->name('process-join');
});






// Admin routes (protected by admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Waitlist statistics
    Route::get('/waitlist-stats', [WaitlistController::class, 'stats'])->name('admin.waitlist-stats');
});

Route::middleware(['auth', 'admin'])->prefix('admin/affiliate')->name('admin.affiliate.')->group(function () {
    Route::get('/dashboard', [AdminAffiliateController::class, 'dashboard'])->name('dashboard');
    Route::get('/affiliates', [AdminAffiliateController::class, 'affiliates'])->name('affiliates');
    Route::get('/affiliates/{id}', [AdminAffiliateController::class, 'showAffiliate'])->name('show-affiliate');
    Route::patch('/affiliates/{id}/status', [AdminAffiliateController::class, 'updateAffiliateStatus'])->name('update-affiliate-status');
    
    Route::get('/referrals', [AdminAffiliateController::class, 'referrals'])->name('referrals');
    Route::patch('/referrals/{id}/status', [AdminAffiliateController::class, 'updateReferralStatus'])->name('update-referral-status');
    
    Route::get('/commissions', [AdminAffiliateController::class, 'commissions'])->name('commissions');
    Route::patch('/commissions/{id}/status', [AdminAffiliateController::class, 'updateCommissionStatus'])->name('update-commission-status');
    Route::post('/commissions/bulk-approve', [AdminAffiliateController::class, 'bulkApproveCommissions'])->name('bulk-approve-commissions');
    
    Route::get('/payouts', [AdminAffiliateController::class, 'payouts'])->name('payouts');
    Route::get('/payouts/{id}', [AdminAffiliateController::class, 'showPayout'])->name('show-payout');
    Route::patch('/payouts/{id}/status', [AdminAffiliateController::class, 'updatePayoutStatus'])->name('update-payout-status');
    
    Route::get('/settings', [AdminAffiliateController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminAffiliateController::class, 'updateSettings'])->name('update-settings');
    
    Route::get('/achievements', [AdminAffiliateController::class, 'achievements'])->name('achievements');
    Route::post('/achievements', [AdminAffiliateController::class, 'storeAchievement'])->name('store-achievement');
    Route::patch('/achievements/{id}', [AdminAffiliateController::class, 'updateAchievement'])->name('update-achievement');
    Route::delete('/achievements/{id}', [AdminAffiliateController::class, 'deleteAchievement'])->name('delete-achievement');
});
