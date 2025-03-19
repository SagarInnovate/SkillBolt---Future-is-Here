<?php

namespace App\Services;

use App\Models\User;
use App\Models\AffiliateDetail;
use App\Models\Referral;
use App\Models\Commission;
use App\Models\ReferralClick;
use App\Models\AffiliateSetting;
use App\Models\Achievement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class AffiliateService
{
    /**
     * Create or update affiliate details for a user.
     */
    public function createAffiliateAccount(User $user): AffiliateDetail
    {
        $affiliateDetail = AffiliateDetail::firstOrNew(['user_id' => $user->id]);
        
        // Generate affiliate code if not already set
        if (!$affiliateDetail->affiliate_code) {
            $affiliateDetail->affiliate_code = $this->generateAffiliateCode($user);
        }
        
        // Set default values for new accounts
        if (!$affiliateDetail->exists) {
            $affiliateDetail->status = 'active';
            $affiliateDetail->tier_level = 1;
            $affiliateDetail->total_earnings = 0;
            $affiliateDetail->available_balance = 0;
            $affiliateDetail->total_referrals = 0;
            $affiliateDetail->successful_referrals = 0;
        }
        
        $affiliateDetail->save();
        
        // Generate QR code if not already done
        if (!$affiliateDetail->qr_code_path) {
            $this->generateQrCode($affiliateDetail);
        }
        
        return $affiliateDetail;
    }
    
    /**
     * Generate a unique affiliate code.
     */
    public function generateAffiliateCode(User $user): string
    {
        $baseCode = strtoupper(substr(str_replace(' ', '', $user->name), 0, 3) . substr($user->id, -4));
        
        // Check if code already exists
        $existingCode = AffiliateDetail::where('affiliate_code', $baseCode)->exists();
        
        if ($existingCode) {
            // Add random string if code already exists
            $baseCode .= Str::random(3);
        }
        
        return $baseCode;
    }
    
    /**
     * Generate a QR code for the affiliate's referral link.
     */
    public function generateQrCode(AffiliateDetail $affiliateDetail): string
    {
        $referralLink = url('/track/ref') . '?code=' . $affiliateDetail->affiliate_code
            . '&utm_source=qrcode'
            . '&utm_medium=image' 
            . '&utm_campaign=user_' . $affiliateDetail->user_id;
        
        $filename = 'qrcodes/' . $affiliateDetail->affiliate_code . '.svg';
        
        // Generate QR code and save it to storage
        $qrCode = QrCode::size(300)->generate($referralLink);
        Storage::disk('public')->put($filename, $qrCode);
        
        // Update the affiliate detail with the QR code path
        $affiliateDetail->qr_code_path = $filename;
        $affiliateDetail->save();
        
        return $filename;
    }
    
    /**
     * Track a referral click.
     */
    public function trackReferralClick(Request $request, string $referralCode): void
    {
        // Create referral click record
        ReferralClick::create([
            'referral_code' => $referralCode,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'source' => $request->header('referer') ? parse_url($request->header('referer'), PHP_URL_HOST) : null,
            'utm_source' => $request->query('utm_source'),
            'utm_medium' => $request->query('utm_medium'),
            'utm_campaign' => $request->query('utm_campaign'),
            'created_at' => now(),
        ]);
        
        // Update total referrals count (clicks)
        $affiliateDetail = AffiliateDetail::where('affiliate_code', $referralCode)->first();
        if ($affiliateDetail) {
            $affiliateDetail->increment('total_referrals');
        }
    }
    
    /**
     * Process a referral when a user registers using a referral code.
     */
    public function processReferral(User $referredUser, string $referralCode): ?Referral
    {
        // Find the referrer
        $affiliateDetail = AffiliateDetail::where('affiliate_code', $referralCode)->first();
        
        if (!$affiliateDetail) {
            return null;
        }
        
        $referrer = $affiliateDetail->user;
        
        // Prevent self-referrals
        if ($referrer->id === $referredUser->id) {
            return null;
        }
        
        // Check if this referral already exists
        $existingReferral = Referral::where('referrer_id', $referrer->id)
            ->where('referred_user_id', $referredUser->id)
            ->first();
            
        if ($existingReferral) {
            return $existingReferral;
        }
        
        // Create the referral
        $referral = Referral::create([
            'referrer_id' => $referrer->id,
            'referred_user_id' => $referredUser->id,
            'status' => 'pending',
        ]);
        
        return $referral;
    }
    
    /**
     * Convert a pending referral to successful and create a commission.
     */
    public function convertReferral(Referral $referral): void
    {
        // Ensure the referral is in pending status
        if ($referral->status !== 'pending') {
            return;
        }
        
        // Mark referral as successful
        $referral->status = 'successful';
        $referral->conversion_date = now();
        $referral->save();
        
        // Update the affiliate's successful referrals count
        $affiliateDetail = AffiliateDetail::where('user_id', $referral->referrer_id)->first();
        if ($affiliateDetail) {
            $affiliateDetail->increment('successful_referrals');
            $this->updateAffiliateTier($affiliateDetail);
        }
        
        // Create commission
        $this->createCommission($referral);
        
        // Check for achievements
        $this->checkReferralAchievements($referral->referrer);
    }
    
    /**
     * Create a commission for a successful referral.
     */
    public function createCommission(Referral $referral): Commission
    {
        // Get base commission amount from settings
        $baseAmount = AffiliateSetting::get('commission_rate', 300);
        
        // Get tier bonus if applicable
        $affiliateDetail = AffiliateDetail::where('user_id', $referral->referrer_id)->first();
        $tierBonus = 0;
        
        if ($affiliateDetail) {
            $tierRequirements = AffiliateSetting::get('tier_requirements', []);
            $tierBonus = $tierRequirements[$affiliateDetail->tier_level]['bonus'] ?? 0;
        }
        
        // Calculate total commission amount
        $totalAmount = $baseAmount + $tierBonus;
        
        // Create the commission record
        $commission = Commission::create([
            'referral_id' => $referral->id,
            'user_id' => $referral->referrer_id,
            'amount' => $totalAmount,
            'status' => 'pending',
            'metadata' => [
                'base_amount' => $baseAmount,
                'tier_bonus' => $tierBonus,
                'tier_level' => $affiliateDetail ? $affiliateDetail->tier_level : 1,
            ],
        ]);
        
        return $commission;
    }
    
    /**
     * Update an affiliate's tier based on successful referrals.
     */
    public function updateAffiliateTier(AffiliateDetail $affiliateDetail): void
    {
        $tierRequirements = AffiliateSetting::get('tier_requirements', []);
        $currentTier = $affiliateDetail->tier_level;
        $successfulReferrals = $affiliateDetail->successful_referrals;
        
        $newTier = $currentTier;
        
        // Check if the affiliate qualifies for a higher tier
        foreach ($tierRequirements as $tier => $requirements) {
            if ($tier > $currentTier && $successfulReferrals >= $requirements['referrals']) {
                $newTier = $tier;
            }
        }
        
        // Update tier if changed
        if ($newTier > $currentTier) {
            $affiliateDetail->tier_level = $newTier;
            $affiliateDetail->save();
            
            // Notify user of tier upgrade (would implement in a notification service)
        }
    }
    
    /**
     * Get the leaderboard of top affiliates.
     */
    public function getLeaderboard(int $limit = 10): array
    {
        $affiliates = AffiliateDetail::with('user')
            ->orderBy('successful_referrals', 'desc')
            ->orderBy('total_earnings', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($affiliate, $index) {
                return [
                    'rank' => $index + 1,
                    'name' => $affiliate->user->name,
                    'referrals' => $affiliate->successful_referrals,
                    'earnings' => $affiliate->total_earnings,
                    'tier' => $affiliate->tier_level,
                    'is_current_user' => auth()->id() === $affiliate->user_id,
                ];
            })
            ->toArray();
            
        return $affiliates;
    }
    
    /**
     * Get the current user's rank on the leaderboard.
     */
    public function getUserRank(User $user): ?int
    {
        $userAffiliateDetail = $user->affiliateDetails;
        
        if (!$userAffiliateDetail) {
            return null;
        }
        
        // Count how many affiliates have more successful referrals
        $rank = AffiliateDetail::where('successful_referrals', '>', $userAffiliateDetail->successful_referrals)
            ->count();
            
        // Add 1 to get the actual rank (0 better affiliates = rank 1)
        return $rank + 1;
    }
    
    /**
     * Check and award referral-based achievements.
     */
    public function checkReferralAchievements(User $user): void
    {
        $affiliateDetail = $user->affiliateDetails;
        
        if (!$affiliateDetail) {
            return;
        }
        
        // Get all active referral-based achievements
        $achievements = Achievement::where('is_active', true)
            ->get()
            ->filter(function ($achievement) {
                $criteria = $achievement->criteria;
                return isset($criteria['type']) && $criteria['type'] === 'referrals';
            });
            
        foreach ($achievements as $achievement) {
            // Skip if user already has this achievement
            if ($user->achievements()->where('achievement_id', $achievement->id)->exists()) {
                continue;
            }
            
            $criteria = $achievement->criteria;
            $threshold = $criteria['threshold'] ?? 0;
            
            // Check if user meets the criteria
            if ($affiliateDetail->successful_referrals >= $threshold) {
                // Award achievement
                $user->achievements()->attach($achievement->id, [
                    'earned_at' => now(),
                    'is_notified' => false,
                ]);
                
                // Would implement notification here
            }
        }
    }


    /**
 * Process a successful purchase by a referred user.
 * This should be called after a user completes their first purchase.
 *
 * @param  \App\Models\User  $user
 * @param  float  $purchaseAmount
 * @return void
 */
public function processFirstPurchase(User $user, float $purchaseAmount = 0): void
{
    // Find any pending referrals for this user
    $referral = Referral::where('referred_user_id', $user->id)
        ->where('status', 'pending')
        ->first();
    
    if ($referral) {
        // Convert the referral to successful
        $this->convertReferral($referral);
    }
}
}