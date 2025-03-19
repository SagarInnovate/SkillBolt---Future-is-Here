<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AffiliateDetail;
use App\Models\Referral;
use App\Models\Commission;
use App\Models\Payout;
use App\Models\AffiliateSetting;
use App\Models\Transaction;
use App\Services\AffiliateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\ReferralClick;
use App\Models\Waitlist;
use App\Models\AuditLog;




class AffiliateController extends Controller
{
    protected $affiliateService;
    
    public function __construct(AffiliateService $affiliateService)
    {
        $this->affiliateService = $affiliateService;
        
        // // Apply middleware to ensure user can access affiliate features
        // $this->middleware('auth');
        // $this->middleware('verified');
    }
    
    /**
     * Display affiliate dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Check if user has affiliate permission and affiliate details
        if (!$user->canAffiliate() || !$user->affiliateDetails) {
            return redirect()->route('affiliate.join')
                ->with('info', 'You need to join the affiliate program first.');
        }
        
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
       // Get referral link and QR code
        $referralLink = url('/track/ref') . '?code=' . $affiliateDetail->affiliate_code
        . '&utm_source=affiliate'
        . '&utm_medium=referral' 
        . '&utm_campaign=user_' . $user->id;

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
        $recentCommissions = Commission::with('referral.referredUser')
            ->where('user_id', $user->id)
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
        
        // Get commission rate from settings
        $commissionRate = AffiliateSetting::get('commission_rate', 300);
        
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
            'achievements',
            'commissionRate'
        ));
    }
    
    /**
     * Display referrals list
     */

    public function referrals( Request $request)
    {
        $user = Auth::user();
        
        // Check if user has affiliate permission and affiliate details
        if (!$user->canAffiliate() || !$user->affiliateDetails) {
            return redirect()->route('affiliate.join')
                ->with('info', 'You need to join the affiliate program first.');
        }
        
  // Filter parameters
  $status = $request->input('status');
  $dateFrom = $request->input('date_from');
  $dateTo = $request->input('date_to');
  
  // Base query with relationship
  $query = Referral::with('referredUser', 'commission')
      ->where('referrer_id', $user->id);
  
  // Apply filters if provided
  if ($status) {
      $query->where('status', $status);
  }
  
  if ($dateFrom) {
      $query->whereDate('created_at', '>=', $dateFrom);
  }
  
  if ($dateTo) {
      $query->whereDate('created_at', '<=', $dateTo);
  }
  
  $referrals = $query->orderBy('created_at', 'desc')->paginate(15);
 
        
        // Get total clicks data
        $totalClicks = ReferralClick::where('referral_code', $user->affiliateDetails->affiliate_code)
            ->count();
        
        // Get conversion rate
        $conversionRate = $user->affiliateDetails->getConversionRateAttribute();
        
        // Calculate waitlisted referrals directly from the database
        $waitlistedReferrals = Waitlist::where('referral_code', $user->affiliateDetails->affiliate_code)
            ->where('is_invited', false) // Not yet converted to user
            ->count();
        
        // Calculate clicks from different sources (for a chart, perhaps)
        $clicksBySource = ReferralClick::where('referral_code', $user->affiliateDetails->affiliate_code)
            ->select('source', DB::raw('count(*) as total'))
            ->groupBy('source')
            ->get();
                
        return view('affiliate.referrals', compact(
            'referrals', 
            'totalClicks', 
            'conversionRate',
            'waitlistedReferrals',
            'clicksBySource'
        ));
    }
    
    /**
     * Display commissions list
     */
    public function commissions()
    {
        $user = Auth::user();
        
        // Check if user has affiliate permission and affiliate details
        if (!$user->canAffiliate() || !$user->affiliateDetails) {
            return redirect()->route('affiliate.join')
                ->with('info', 'You need to join the affiliate program first.');
        }
        
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
        $user = Auth::user();
        
        // Check if user has affiliate permission and affiliate details
        if (!$user->canAffiliate() || !$user->affiliateDetails) {
            return redirect()->route('affiliate.join')
                ->with('info', 'You need to join the affiliate program first.');
        }
        
        $leaderboard = $this->affiliateService->getLeaderboard(50);
        $userRank = $this->affiliateService->getUserRank($user);
        
        return view('affiliate.leaderboard', compact('leaderboard', 'userRank'));
    }
    
    /**
     * Display payout history and request form
     */
    public function payouts()
    {
        $user = Auth::user();
        
        // Check if user has affiliate permission and affiliate details
        if (!$user->canAffiliate() || !$user->affiliateDetails) {
            return redirect()->route('affiliate.join')
                ->with('info', 'You need to join the affiliate program first.');
        }
        
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
        
        // Check if user has affiliate permission and affiliate details
        if (!$user->canAffiliate() || !$user->affiliateDetails) {
            return redirect()->route('affiliate.join')
                ->with('info', 'You need to join the affiliate program first.');
        }
        
        // Validate request
        $request->validate([
            'payment_method' => 'required|in:bank_transfer,upi,wallet_credit',
            'payment_details' => 'required|string',
        ]);
        
        $availableBalance = Transaction::calculateUserBalance($user->id);
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
        \DB::transaction(function() use ($user, $request, $availableBalance) {
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
                
            // Create transaction record - this will be pending until payout is completed
            Transaction::createTransaction(
                $user->id,
                'payout_request',
                $availableBalance,
                'debit',
                'Payout request #' . $payout->id,
                $payout,
                ['payment_method' => $request->payment_method],
                'INR',
                'pending'
            );
            
            // Log the payout request
            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'payout_requested',
                'details' => json_encode([
                    'payout_id' => $payout->id,
                    'amount' => (string) $availableBalance,
                    'payment_method' => $request->payment_method
                ]),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
        });
        
        return redirect()->route('affiliate.payouts')
            ->with('success', 'Payout request submitted successfully!');
    }
    /**
     * Generate and return QR code for referral link
     */
    public function generateQrCode()
    {
        $user = Auth::user();
        
        // Check if user has affiliate permission and affiliate details
        if (!$user->canAffiliate() || !$user->affiliateDetails) {
            return response()->json(['error' => 'Not authorized'], 403);
        }
        
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

    /**
     * Show the form to join the affiliate program
     */
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
        
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'joined_affiliate_program',
            'details' => json_encode([
                'affiliate_code' => $affiliateDetail->affiliate_code
            ]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        // Redirect to the affiliate dashboard
        return redirect()->route('affiliate.dashboard')
            ->with('success', 'You have successfully joined the affiliate program!');
    }
}