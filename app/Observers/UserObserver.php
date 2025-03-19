<?php

namespace App\Observers;

use App\Models\User;
use App\Services\AffiliateService;

class UserObserver
{
    protected $affiliateService;
    
    public function __construct(AffiliateService $affiliateService)
    {
        $this->affiliateService = $affiliateService;
    }
    
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
/**
 * Handle the User "created" event.
 *
 * @param  \App\Models\User  $user
 * @return void
 */
public function created(User $user)
{
    \Illuminate\Support\Facades\Log::info('UserObserver created method called', [
        'user_id' => $user->id,
        'user_email' => $user->email,
        'has_referral_code' => session()->has('referral_code'),
        'referral_code' => session('referral_code')
    ]);

    // Check if user has a stored referral code in session or cookie
    $referralCode = session('referral_code') ?? request()->cookie('referral_code');
    
    if ($referralCode) {
        // Process referral
        $referral = $this->affiliateService->processReferral($user, $referralCode);
        
        \Illuminate\Support\Facades\Log::info('Referral processed in UserObserver', [
            'referral_created' => $referral ? true : false,
            'referral_id' => $referral ? $referral->id : null,
            'user_id' => $user->id,
            'referral_code' => $referralCode
        ]);
        
        // Clear referral data from session
        session()->forget('referral_code');
    }
}

}