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
    public function created(User $user)
    {
        // Check if user has a stored referral code in session
        if (session()->has('referral_code')) {
            $referralCode = session()->get('referral_code');
            // Process referral
            $this->affiliateService->processReferral($user, $referralCode);
            // Remove from session
            session()->forget('referral_code');
        }
    }
}