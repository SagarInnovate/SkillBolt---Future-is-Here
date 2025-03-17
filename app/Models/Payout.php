<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payout extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'amount',
        'payment_method',
        'status',
        'transaction_id',
        'payment_details',
        'payout_date',
        'notes',
    ];
    
    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'payout_date' => 'datetime',
    ];
    
    /**
     * Get the user associated with this payout.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the commissions included in this payout.
     */
    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }
    
    /**
     * Mark the payout as completed.
     */
    public function markAsCompleted(string $transactionId = null): void
    {
        $this->status = 'completed';
        $this->payout_date = now();
        
        if ($transactionId) {
            $this->transaction_id = $transactionId;
        }
        
        $this->save();
        
        // Update commissions status to paid
        $this->commissions()->update(['status' => 'paid']);
        
        // Update affiliate available balance
        $affiliateDetail = AffiliateDetail::where('user_id', $this->user_id)->first();
        if ($affiliateDetail) {
            $affiliateDetail->decrement('available_balance', $this->amount);
        }
    }
}