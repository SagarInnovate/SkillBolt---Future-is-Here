<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AffiliateDetail;
use App\Models\Referral;
use App\Models\Commission;
use App\Models\Payout;
use App\Models\AffiliateSetting;
use App\Services\AffiliateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AffiliateController extends Controller
{
    protected $affiliateService;
    
    public function __construct(AffiliateService $affiliateService)
    {
        $this->affiliateService = $affiliateService;
    }
    
    /**
     * Display affiliate dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Create or get affiliate account
        $affiliateDetail = $this->affiliateService->createAffiliateAccount($user);
        
        // Get statistics
        $referrals = Referral::where('referrer_id', $user->id)->count();
        $successfulReferrals = Referral::where('referrer_id', $user->id)
            ->where('status', 'successful')
            ->count();
        $pendingReferrals = Referral::where('referrer_id', $user->id)
            ->where('status', 'pending')
            ->count();
            
        $pendingCommissions = Commission::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');
            
        $approvedCommissions = Commission::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount');
            
        $totalEarnings = $affiliateDetail->total_earnings;
        $availableBalance = $affiliateDetail->available_balance;
        
        // Get referral link and QR code
        $referralLink = url('/?ref=' . $affiliateDetail->affiliate_code);
        $qrCodeUrl = $affiliateDetail->qr_code_path 
            ? Storage::url($affiliateDetail->qr_code_path) 
            : null;
            
        // Get user's rank
        $userRank = $this->affiliateService->getUserRank($user);
        
        // Get leaderboard
        $leaderboard = $this->affiliateService->getLeaderboard(5);
        
        // Get recent referrals
        $recentReferrals = Referral::with('referredUser')
            ->where('referrer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get recent commissions
        $recentCommissions = Commission::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Check if user can request payout
        $canRequestPayout = $user->canRequestPayout();
        $minPayoutThreshold = AffiliateSetting::get('min_payout_threshold', 1000);
        
        // Get tier information
        $tierRequirements = AffiliateSetting::get('tier_requirements', []);
        $currentTier = $affiliateDetail->tier_level;
        $nextTier = $currentTier + 1;
        
        $currentTierInfo = $tierRequirements[$currentTier] ?? null;
        $nextTierInfo = $tierRequirements[$nextTier] ?? null;
        
        $nextTierProgress = 0;
        if ($nextTierInfo) {
            $requiredReferrals = $nextTierInfo['referrals'];
            $currentReferrals = $affiliateDetail->successful_referrals;
            $prevTierReferrals = $currentTierInfo['referrals'];
            
            $totalNeeded = $requiredReferrals - $prevTierReferrals;
            $currentProgress = $currentReferrals - $prevTierReferrals;
            
            $nextTierProgress = $totalNeeded > 0 ? min(100, ($currentProgress / $totalNeeded) * 100) : 100;
        }
        
        // Get user achievements
        $achievements = $user->achievements;
        
        return view('affiliate.dashboard', compact(
            'affiliateDetail',
            'referrals',
            'successfulReferrals',
            'pendingReferrals',
            'pendingCommissions',
            'approvedCommissions',
            'totalEarnings',
            'availableBalance',
            'referralLink',
            'qrCodeUrl',
            'userRank',
            'leaderboard',
            'recentReferrals',
            'recentCommissions',
            'canRequestPayout',
            'minPayoutThreshold',
            'currentTier',
            'nextTier',
            'currentTierInfo',
            'nextTierInfo',
            'nextTierProgress',
            'achievements'
        ));
    }
    
    /**
     * Display referrals list
     */
    public function referrals()
    {
        $user = Auth::user();
        
        $referrals = Referral::with('referredUser')
            ->where('referrer_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('affiliate.referrals', compact('referrals'));
    }
    
    /**
     * Display commissions list
     */
    public function commissions()
    {
        $user = Auth::user();
        
        $commissions = Commission::with('referral.referredUser')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('affiliate.commissions', compact('commissions'));
    }
    
    /**
     * Display leaderboard
     */
    public function leaderboard()
    {
        $leaderboard = $this->affiliateService->getLeaderboard(50);
        $userRank = $this->affiliateService->getUserRank(Auth::user());
        
        return view('affiliate.leaderboard', compact('leaderboard', 'userRank'));
    }
    
    /**
     * Display payout history and request form
     */
    public function payouts()
    {
        $user = Auth::user();
        
        $payouts = Payout::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        $pendingPayout = Payout::where('user_id', $user->id)
            ->whereIn('status', ['processing'])
            ->first();
            
        $availableBalance = $user->affiliateDetails ? $user->affiliateDetails->available_balance : 0;
        $minPayoutThreshold = AffiliateSetting::get('min_payout_threshold', 1000);
        $canRequestPayout = $availableBalance >= $minPayoutThreshold && !$pendingPayout;
        
        return view('affiliate.payouts', compact('payouts', 'pendingPayout', 'availableBalance', 'minPayoutThreshold', 'canRequestPayout'));
    }
    
    /**
     * Request a payout
     */
    public function requestPayout(Request $request)
    {
        $user = Auth::user();
        
        // Validate request
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,upi,wallet_credit',
            'payment_details' => 'required|string',
        ]);
        
        $availableBalance = $user->affiliateDetails ? $user->affiliateDetails->available_balance : 0;
        $minPayoutThreshold = AffiliateSetting::get('min_payout_threshold', 1000);
        
        // Check if user can request payout
        if ($availableBalance < $minPayoutThreshold) {
            return back()->with('error', 'You need at least ₹' . $minPayoutThreshold . ' to request a payout.');
        }
        
        // Check if user already has a pending payout
        $pendingPayout = Payout::where('user_id', $user->id)
            ->whereIn('status', ['processing'])
            ->first();
            
        if ($pendingPayout) {
            return back()->with('error', 'You already have a pending payout request.');
        }
        
        // Create payout request
        $payout = Payout::create([
            'user_id' => $user->id,
            'amount' => $availableBalance,
            'payment_method' => $request->payment_method,
            'status' => 'processing',
            'payment_details' => $request->payment_details,
        ]);
        
        // Get pending and approved commissions to associate with this payout
        Commission::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->update(['payout_id' => $payout->id]);
            
        return redirect()->route('affiliate.payouts')
            ->with('success', 'Payout request submitted successfully!');
    }
    
    /**
     * Generate and return QR code for referral link
     */
    public function generateQrCode()
    {
        $user = Auth::user();
        $affiliateDetail = $user->affiliateDetails;
        
        if (!$affiliateDetail) {
            $affiliateDetail = $this->affiliateService->createAffiliateAccount($user);
        }
        
        if (!$affiliateDetail->qr_code_path) {
            $this->affiliateService->generateQrCode($affiliateDetail);
            $affiliateDetail->refresh();
        }
        
        return response()->json([
            'qr_code_url' => Storage::url($affiliateDetail->qr_code_path),
        ]);
    }

    public function showJoinForm()
{
    // Check if user already has an affiliate account
    if (auth()->user()->canAffiliate() && auth()->user()->affiliateDetails) {
        return redirect()->route('affiliate.dashboard')
            ->with('info', 'You are already an affiliate.');
    }
    
    // Get the commission rate from settings
    $commissionRate = AffiliateSetting::get('commission_rate', 300);
    
    // Get tier requirements
    $tierRequirements = AffiliateSetting::get('tier_requirements', []);
    
    return view('affiliate.join', compact('commissionRate', 'tierRequirements'));
}

/**
 * Process the join affiliate program request
 */
public function processJoin(Request $request)
{
    // Check if user already has an affiliate account
    if (auth()->user()->canAffiliate() && auth()->user()->affiliateDetails) {
        return redirect()->route('affiliate.dashboard')
            ->with('info', 'You are already an affiliate.');
    }
    
    // Add the affiliate permission to the user
    auth()->user()->permissions()->attach(
        \App\Models\Permission::where('name', 'can_affiliate')->first()->id,
        ['status' => 'active', 'granted_at' => now()]
    );
    
    // Create affiliate account
    $affiliateDetail = $this->affiliateService->createAffiliateAccount(auth()->user());
    
    // Redirect to the affiliate dashboard
    return redirect()->route('affiliate.dashboard')
        ->with('success', 'You have successfully joined the affiliate program!');
}
}
