<?php

namespace App\Http\Controllers;

use App\Models\Waitlist;
use App\Models\AffiliateDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\WaitlistConfirmation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class WaitlistController extends Controller
{
    use AuthorizesRequests; 
    /**
     * Store waitlist entry
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:waitlist,email',
            'name' => 'nullable|string|max:255',
            'referral_code' => 'nullable|string|exists:affiliate_details,affiliate_code',
        ]);

        try {
            // Create waitlist entry
            $waitlist = Waitlist::create([
                'email' => $request->email,
                'name' => $request->name,
                'referral_code' => $request->referral_code,
                'is_invited' => false,
            ]);

            // Increment referral count if referred
            if ($request->filled('referral_code')) {
                $this->processReferral($request->referral_code);
            }

            // Send confirmation email
            Mail::to($request->email)->send(new WaitlistConfirmation($waitlist));

            return redirect()->back()->with('success', 'You have been added to our waitlist! Check your email for confirmation.');
        } catch (\Exception $e) {
            Log::error('Waitlist submission error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'There was an error joining the waitlist. Please try again later.');
        }
    }

    /**
     * Process referral for waitlist signups
     */
    private function processReferral($referralCode)
    {
        $affiliateDetail = AffiliateDetail::where('affiliate_code', $referralCode)->first();
        
        if ($affiliateDetail) {
            // Increment referral count
            $affiliateDetail->increment('total_referrals');
            
            // Get the user
            $user = User::find($affiliateDetail->user_id);
            
            // Send notification to referrer (optional)
            // Mail::to($user->email)->send(new ReferralNotification($user));
        }
    }

    /**
     * Display waitlist statistics (admin only)
     */
    public function stats()
    {
        $this->authorize('viewWaitlistStats', Waitlist::class);
        
        $stats = [
            'total' => Waitlist::count(),
            'converted' => Waitlist::whereNotNull('converted_user_id')->count(),
            'recent' => Waitlist::orderBy('created_at', 'desc')->take(10)->get(),
            'topReferrers' => AffiliateDetail::where('total_referrals', '>', 0)
                ->orderBy('total_referrals', 'desc')
                ->take(10)
                ->with('user')
                ->get(),
        ];
        
        return view('admin.waitlist-stats', compact('stats'));
    }

    /**
     * Generate referral link for a user
     */
    public function getReferralLink(Request $request)
    {
        $user = $request->user();
        
        if (!$user->canAffiliate()) {
            return response()->json([
                'error' => 'You do not have permission to generate referral links.'
            ], 403);
        }
        
        // Get or create affiliate details
        $affiliateDetail = $user->affiliateDetails;
        
        if (!$affiliateDetail) {
            $affiliateDetail = AffiliateDetail::create([
                'user_id' => $user->id,
                'affiliate_code' => $this->generateAffiliateCode($user),
                'total_referrals' => 0
            ]);
        }
        
        $referralLink = url('/') . '?ref=' . $affiliateDetail->affiliate_code;
        
        return response()->json([
            'referral_code' => $affiliateDetail->affiliate_code,
            'referral_link' => $referralLink,
            'total_referrals' => $affiliateDetail->total_referrals
        ]);
    }

    /**
     * Generate unique affiliate code
     */
    private function generateAffiliateCode($user)
    {
        $baseCode = strtoupper(substr(str_replace(' ', '', $user->name), 0, 3) . substr(md5($user->email), 0, 5));
        
        // Check if code already exists
        $existingCode = AffiliateDetail::where('affiliate_code', $baseCode)->exists();
        
        if ($existingCode) {
            $baseCode .= rand(10, 99);
        }
        
        return $baseCode;
    }
}