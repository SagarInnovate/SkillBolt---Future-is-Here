<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateDetail;
use App\Models\Referral;
use App\Models\Commission;
use App\Models\Payout;
use App\Models\AffiliateSetting;
use App\Models\Achievement;
use App\Services\AffiliateService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\User;
use App\Models\AuditLog;


class AdminAffiliateController extends Controller
{
    protected $affiliateService;
    
    public function __construct(AffiliateService $affiliateService)
    {
        $this->affiliateService = $affiliateService;
        // $this->middleware('admin');
    }
    
    /**
     * Display affiliate program dashboard
     */
    public function dashboard()
    {
        // Get statistics
        $totalAffiliates = AffiliateDetail::count();
        $activeAffiliates = AffiliateDetail::where('status', 'active')->count();
        $totalReferrals = Referral::count();
        $successfulReferrals = Referral::where('status', 'successful')->count();
        $conversionRate = $totalReferrals > 0 ? round(($successfulReferrals / $totalReferrals) * 100, 2) : 0;
        
        $totalCommissions = Commission::sum('amount');
        $pendingCommissions = Commission::where('status', 'pending')->sum('amount');
        $approvedCommissions = Commission::where('status', 'approved')->sum('amount');
        $paidCommissions = Commission::where('status', 'paid')->sum('amount');
        
        // Get monthly referrals trend
        $monthlyReferrals = Referral::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->limit(12)
            ->get()
            ->reverse();
            
        // Get top affiliates
        $topAffiliates = AffiliateDetail::with('user')
            ->orderBy('successful_referrals', 'desc')
            ->limit(10)
            ->get();
            
        // Get recent payouts
        $recentPayouts = Payout::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Get current settings
        $settings = AffiliateSetting::all()->keyBy('key');
        
        return view('admin.affiliate.dashboard', compact(
            'totalAffiliates',
            'activeAffiliates',
            'totalReferrals',
            'successfulReferrals',
            'conversionRate',
            'totalCommissions',
            'pendingCommissions',
            'approvedCommissions',
            'paidCommissions',
            'monthlyReferrals',
            'topAffiliates',
            'recentPayouts',
            'settings'
        ));
    }
    
    /**
     * Display affiliates list
     */
    public function affiliates(Request $request)
    {
        $query = AffiliateDetail::with('user');
        
        // Apply filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('affiliate_code', 'like', "%{$search}%");
        }
        
        if ($request->has('tier') && $request->tier != '') {
            $query->where('tier_level', $request->tier);
        }
        
        // Sort
        $sortField = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        
        $validSortFields = ['created_at', 'total_referrals', 'successful_referrals', 'tier_level', 'total_earnings'];
        
        if (in_array($sortField, $validSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');
        }
        
        $affiliates = $query->paginate(15)->appends($request->query());
        
        return view('admin.affiliate.affiliates', compact('affiliates'));
    }
    
    /**
     * Show affiliate details
     */
    public function showAffiliate($id)
    {
        $affiliateDetail = AffiliateDetail::with('user')->findOrFail($id);
        
        $referrals = Referral::with('referredUser')
            ->where('referrer_id', $affiliateDetail->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'referrals_page');
            
        $commissions = Commission::with('referral')
            ->where('user_id', $affiliateDetail->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'commissions_page');
            
        $payouts = Payout::where('user_id', $affiliateDetail->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'payouts_page');
            
        $referralClicks = DB::table('referral_clicks')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('referral_code', $affiliateDetail->affiliate_code)
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();
            
        $achievements = $affiliateDetail->user->achievements;
        
        return view('admin.affiliate.show', compact(
            'affiliateDetail',
            'referrals',
            'commissions',
            'payouts',
            'referralClicks',
            'achievements'
        ));
    }
    
    /**
     * Update affiliate status
     */
    public function updateAffiliateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,suspended',
        ]);
        
        $affiliateDetail = AffiliateDetail::findOrFail($id);
        $affiliateDetail->status = $request->status;
        $affiliateDetail->save();
        
        return redirect()->back()->with('success', 'Affiliate status updated successfully!');
    }
    
    /**
     * Display referrals list
     */
    public function referrals(Request $request)
    {
        $query = Referral::with(['referrer', 'referredUser']);
        
        // Apply filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('referrer', function($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('referredUser', function($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                });
            });
        }
        
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Sort
        $sortField = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        
        $validSortFields = ['created_at', 'conversion_date', 'status'];
        
        if (in_array($sortField, $validSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');
        }
        
        $referrals = $query->paginate(15)->appends($request->query());
        
        return view('admin.affiliate.referrals', compact('referrals'));
    }
    
    /**
     * Update referral status
     */
    public function updateReferralStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,successful,failed',
        ]);
        
        $referral = Referral::findOrFail($id);
        $oldStatus = $referral->status;
        $newStatus = $request->status;
        
        // If status is changing to successful, process the conversion
        if ($oldStatus !== 'successful' && $newStatus === 'successful') {
            $this->affiliateService->convertReferral($referral);
            return redirect()->back()->with('success', 'Referral marked as successful and commission created!');
        }
        
        // If status is changing from successful to something else, handle the reversal
        if ($oldStatus === 'successful' && $newStatus !== 'successful') {
            // Update referral status
            $referral->status = $newStatus;
            $referral->save();
            
            // Handle commission reversal
            $commission = Commission::where('referral_id', $referral->id)->first();
            if ($commission && $commission->status !== 'paid') {
                $commission->status = 'rejected';
                $commission->notes = 'Referral status changed from successful to ' . $newStatus;
                $commission->save();
                
                // Update affiliate statistics
                $affiliateDetail = AffiliateDetail::where('user_id', $referral->referrer_id)->first();
                if ($affiliateDetail) {
                    $affiliateDetail->decrement('successful_referrals');
                    
                    // Only adjust balances if commission was approved
                    if ($commission->status === 'approved') {
                        $affiliateDetail->decrement('total_earnings', $commission->amount);
                        $affiliateDetail->decrement('available_balance', $commission->amount);
                    }
                }
            }
            
            return redirect()->back()->with('success', 'Referral status updated and related commission rejected.');
        }
        
        // Just update the status for other cases
        $referral->status = $newStatus;
        $referral->save();
        
        return redirect()->back()->with('success', 'Referral status updated successfully!');
    }
    
    /**
     * Display commissions list
     */
    public function commissions(Request $request)
    {
        $query = Commission::with(['user', 'referral.referredUser']);
        
        // Apply filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        if ($request->has('min_amount') && $request->min_amount != '') {
            $query->where('amount', '>=', $request->min_amount);
        }
        
        if ($request->has('max_amount') && $request->max_amount != '') {
            $query->where('amount', '<=', $request->max_amount);
        }
        
        // Sort
        $sortField = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        
        $validSortFields = ['created_at', 'amount', 'status'];
        
        if (in_array($sortField, $validSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');
        }
        
        $commissions = $query->paginate(15)->appends($request->query());
        
        return view('admin.affiliate.commissions', compact('commissions'));
    }
    
    /**
     * Update commission status
     */
    public function updateCommissionStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'notes' => 'nullable|string|max:255',
        ]);
        
        $commission = Commission::findOrFail($id);
        $oldStatus = $commission->status;
        $newStatus = $request->status;
        
        // If already paid, don't allow changes
        if ($oldStatus === 'paid') {
            return redirect()->back()->with('error', 'Cannot update a paid commission.');
        }
        
        // Update commission
        $commission->status = $newStatus;
        
        if ($request->has('notes') && $request->notes) {
            $commission->notes = $request->notes;
        }
        
        $commission->save();
        
        // Handle changes in available balance
        $affiliateDetail = AffiliateDetail::where('user_id', $commission->user_id)->first();
        
        if ($affiliateDetail) {
            // If changing from pending to approved, add to available balance
            if ($oldStatus === 'pending' && $newStatus === 'approved') {
                $affiliateDetail->increment('total_earnings', $commission->amount);
                $affiliateDetail->increment('available_balance', $commission->amount);
                
                return redirect()->back()->with('success', 'Commission approved and added to affiliate balance.');
            }
            
            // If changing from approved to rejected, subtract from available balance
            if ($oldStatus === 'approved' && $newStatus === 'rejected') {
                $affiliateDetail->decrement('total_earnings', $commission->amount);
                $affiliateDetail->decrement('available_balance', $commission->amount);
                
                return redirect()->back()->with('success', 'Commission rejected and removed from affiliate balance.');
            }
        }
        
        return redirect()->back()->with('success', 'Commission status updated successfully!');
    }
    
    /**
     * Approve multiple commissions
     */
    public function bulkApproveCommissions(Request $request)
    {
        $request->validate([
            'commission_ids' => 'required|array',
            'commission_ids.*' => 'exists:commissions,id',
        ]);
        
        $count = 0;
        
        foreach ($request->commission_ids as $id) {
            $commission = Commission::find($id);
            
            if ($commission && $commission->status === 'pending') {
                $commission->status = 'approved';
                $commission->save();
                
                // Update affiliate balance
                $affiliateDetail = AffiliateDetail::where('user_id', $commission->user_id)->first();
                if ($affiliateDetail) {
                    $affiliateDetail->increment('total_earnings', $commission->amount);
                    $affiliateDetail->increment('available_balance', $commission->amount);
                }
                
                $count++;
            }
        }
        
        return redirect()->back()->with('success', $count . ' commissions approved successfully!');
    }
    
    /**
     * Display payouts list
     */
    public function payouts(Request $request)
    {
        $query = Payout::with('user');
        
        // Apply filters
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('transaction_id', 'like', "%{$search}%");
        }
        
        if ($request->has('date_from') && $request->date_from != '') {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to != '') {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        if ($request->has('payment_method') && $request->payment_method != '') {
            $query->where('payment_method', $request->payment_method);
        }
        
        // Sort
        $sortField = $request->sort_by ?? 'created_at';
        $sortDirection = $request->sort_direction ?? 'desc';
        
        $validSortFields = ['created_at', 'amount', 'status', 'payout_date'];
        
        if (in_array($sortField, $validSortFields)) {
            $query->orderBy($sortField, $sortDirection === 'asc' ? 'asc' : 'desc');
        }
        
        $payouts = $query->paginate(15)->appends($request->query());
        
        return view('admin.affiliate.payouts', compact('payouts'));
    }
    
    /**
     * Show payout details
     */
    public function showPayout($id)
    {
        $payout = Payout::with(['user', 'commissions'])->findOrFail($id);
        
        return view('admin.affiliate.show-payout', compact('payout'));
    }
    
    /**
     * Update payout status
     */
    public function updatePayoutStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:processing,completed,failed',
            'transaction_id' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
        ]);
        
        $payout = Payout::findOrFail($id);
        $oldStatus = $payout->status;
        $newStatus = $request->status;
        
        // Update payout
        $payout->status = $newStatus;
        
        if ($request->has('transaction_id') && $request->transaction_id) {
            $payout->transaction_id = $request->transaction_id;
        }
        
        if ($request->has('notes') && $request->notes) {
            $payout->notes = $request->notes;
        }
        
        if ($newStatus === 'completed') {
            $payout->payout_date = now();
        }
        
        $payout->save();
        
        // If completed, mark commissions as paid
        if ($newStatus === 'completed') {
            Commission::where('payout_id', $payout->id)->update(['status' => 'paid']);
        }
        
        // If failed, revert the commission statuses and return to available balance
        if ($newStatus === 'failed') {
            Commission::where('payout_id', $payout->id)->update(['status' => 'approved']);
            
            // Return the funds to available balance
            $affiliateDetail = AffiliateDetail::where('user_id', $payout->user_id)->first();
            if ($affiliateDetail) {
                $affiliateDetail->increment('available_balance', $payout->amount);
            }
        }
        
        return redirect()->back()->with('success', 'Payout status updated successfully!');
    }
    
    /**
     * Display affiliate settings
     */
    public function settings()
    {
        $settings = AffiliateSetting::pluck('value', 'key')->toArray();
        
        // Parse tier requirements for display
        $tierRequirementsJson = AffiliateSetting::where('key', 'tier_requirements')->value('value');
        $tierRequirements = json_decode($tierRequirementsJson, true);
        
        // print_r($settings['key']);
        return view('admin.affiliate.settings', compact('settings', 'tierRequirements'));
    }
    
    /**
     * Update affiliate settings
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'commission_rate' => 'required|numeric|min:0',
            'min_payout_threshold' => 'required|numeric|min:0',
            'leaderboard_refresh_hours' => 'required|numeric|min:1|max:168',
            'affiliate_program_active' => 'required|boolean',
            'tier_requirements' => 'required|array',
        ]);
        
        // Update basic settings
        AffiliateSetting::set('commission_rate', $request->commission_rate, 'number');
        AffiliateSetting::set('min_payout_threshold', $request->min_payout_threshold, 'number');
        AffiliateSetting::set('leaderboard_refresh_hours', $request->leaderboard_refresh_hours, 'number');
        AffiliateSetting::set('affiliate_program_active', $request->affiliate_program_active ? 'true' : 'false', 'boolean');
        
        // Update tier requirements
        AffiliateSetting::set('tier_requirements', $request->tier_requirements, 'json');
        
        return redirect()->back()->with('success', 'Affiliate settings updated successfully!');
    }
    
    /**
     * Display achievements management
     */
    public function achievements()
    {
        $achievements = Achievement::all();
        
        return view('admin.affiliate.achievements', compact('achievements'));
    }
    
    /**
     * Create a new achievement
     */
    public function storeAchievement(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'criteria_type' => 'required|in:referrals,earnings,tier',
            'criteria_threshold' => 'required|numeric|min:0',
            'points_value' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);
        
        // Create criteria JSON
        $criteria = [
            'type' => $request->criteria_type,
            'threshold' => $request->criteria_threshold,
        ];
        
        // Create achievement
        Achievement::create([
            'name' => $request->name,
            'description' => $request->description,
            'criteria' => $criteria,
            'points_value' => $request->points_value,
            'is_active' => $request->is_active,
        ]);
        
        return redirect()->back()->with('success', 'Achievement created successfully!');
    }
    
    /**
     * Update an achievement
     */
    public function updateAchievement(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'criteria_type' => 'required|in:referrals,earnings,tier',
            'criteria_threshold' => 'required|numeric|min:0',
            'points_value' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',
        ]);
        
        $achievement = Achievement::findOrFail($id);
        
        // Update criteria JSON
        $criteria = [
            'type' => $request->criteria_type,
            'threshold' => $request->criteria_threshold,
        ];
        
        // Update achievement
        $achievement->update([
            'name' => $request->name,
            'description' => $request->description,
            'criteria' => $criteria,
            'points_value' => $request->points_value,
            'is_active' => $request->is_active,
        ]);
        
        return redirect()->back()->with('success', 'Achievement updated successfully!');
    }
    
    /**
     * Delete an achievement
     */
    public function deleteAchievement($id)
    {
        $achievement = Achievement::findOrFail($id);
        $achievement->delete();
        
        return redirect()->back()->with('success', 'Achievement deleted successfully!');
    }

    public function reconcileBalances()
    {
        // Start with empty results array
        $results = [
            'total_checked' => 0,
            'discrepancies' => [],
            'successful' => 0
        ];
        
        // Get all affiliate details
        $affiliateDetails = AffiliateDetail::all();
        $results['total_checked'] = $affiliateDetails->count();
        
        foreach ($affiliateDetails as $detail) {
            $storedBalance = $detail->available_balance;
            $calculatedBalance = Transaction::calculateUserBalance($detail->user_id);
            
            // Check for discrepancies
            if (bccomp((string) $storedBalance, (string) $calculatedBalance, 2) !== 0) {
                // Log the discrepancy
                AuditLog::create([
                    'user_id' => auth()->id(),
                    'action' => 'balance_discrepancy_detected',
                    'details' => json_encode([
                        'user_id' => $detail->user_id,
                        'stored_balance' => (string) $storedBalance,
                        'calculated_balance' => (string) $calculatedBalance,
                        'difference' => (string) ($calculatedBalance - $storedBalance)
                    ])
                ]);
                
                // Add to results array
                $results['discrepancies'][] = [
                    'user_id' => $detail->user_id,
                    'affiliate_id' => $detail->id,
                    'name' => $detail->user->name,
                    'email' => $detail->user->email,
                    'stored_balance' => $storedBalance,
                    'calculated_balance' => $calculatedBalance,
                    'difference' => $calculatedBalance - $storedBalance
                ];
            } else {
                $results['successful']++;
            }
            
            // Update reconciliation timestamp
            $detail->last_reconciled_at = now();
            $detail->save();
        }
        
        return view('admin.affiliate.reconcile-results', compact('results'));
    }

    public function fixBalanceDiscrepancy($userId)
    {
        $user = User::findOrFail($userId);
        $affiliateDetail = $user->affiliateDetails;
        
        if (!$affiliateDetail) {
            return back()->with('error', 'Affiliate account not found.');
        }
        
        $storedBalance = $affiliateDetail->available_balance;
        $calculatedBalance = Transaction::calculateUserBalance($userId);
        
        // Calculate total earnings as well (if needed)
        $totalCredits = Transaction::where('user_id', $userId)
            ->where('type', 'credit')
            ->where('status', 'completed')
            ->sum('amount');
        
        // Log the action with IP and user agent
        AuditLog::create([
            'user_id' => auth()->id(),
            'action' => 'balance_manual_correction',
            'details' => json_encode([
                'user_id' => $userId,
                'old_balance' => (string) $storedBalance,
                'new_balance' => (string) $calculatedBalance,
                'old_total_earnings' => (string) $affiliateDetail->total_earnings,
                'new_total_earnings' => (string) $totalCredits,
                'admin_id' => auth()->id()
            ]),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
        
        // Update both the available balance and total earnings
        $affiliateDetail->available_balance = $calculatedBalance;
        $affiliateDetail->total_earnings = $totalCredits;
        $affiliateDetail->save();
        
        return back()->with('success', "Balance corrected for user #{$userId}. Old balance: ₹{$storedBalance}, New balance: ₹{$calculatedBalance}");
    }
}