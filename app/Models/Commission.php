<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commission extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'referral_id',
        'user_id',
        'amount',
        'status',
        'payout_id',
        'notes',
        'metadata',
    ];
    
    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'json',
    ];
    
    /**
     * Get the referral associated with this commission.
     */
    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }
    
    /**
     * Get the user who earns this commission.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the payout associated with this commission.
     */
    public function payout()
    {
        return $this->belongsTo(Payout::class);
    }
    
    /**
     * Mark the commission as approved.
     */
    public function approve(): void
    {
        $this->status = 'approved';
        $this->save();
        
        // Update affiliate available balance
        $affiliateDetail = AffiliateDetail::where('user_id', $this->user_id)->first();
        if ($affiliateDetail) {
            $affiliateDetail->increment('total_earnings', $this->amount);
            $affiliateDetail->increment('available_balance', $this->amount);

            Transaction::createTransaction(
                $user->id, 
                'commission_earned', 
                $amount, 
                'credit', 
                'Commission earned for referral #' . $referral->id,
                $referral
            );
        }
    }
}
