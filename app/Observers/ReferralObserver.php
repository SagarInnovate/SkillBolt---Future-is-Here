<?php

namespace App\Observers;

use App\Models\Referral;
use App\Services\AffiliateService;

class ReferralObserver
{
    protected $affiliateService;
    
    public function __construct(AffiliateService $affiliateService)
    {
        $this->affiliateService = $affiliateService;
    }
    
    /**
     * Handle the Referral "created" event.
     *
     * @param  \App\Models\Referral  $referral
     * @return void
     */
    public function created(Referral $referral)
    {
        // This is intentionally left empty as we only want to explicitly convert
        // referrals to 'successful' status after certain criteria are met
    }

    /**
     * Handle the Referral "updated" event.
     *
     * @param  \App\Models\Referral  $referral
     * @return void
     */
    public function updated(Referral $referral)
    {
        // If the referral status just changed to successful
        if ($referral->isDirty('status') && $referral->status === 'successful' && $referral->getOriginal('status') !== 'successful') {
            // Ensure we don't create duplicate commissions
            if (!$referral->commission()->exists()) {
                // Create a commission
                $this->affiliateService->createCommission($referral);
            }
            
            // Check for achievements
            $this->affiliateService->checkReferralAchievements($referral->referrer);
        }
    }
}