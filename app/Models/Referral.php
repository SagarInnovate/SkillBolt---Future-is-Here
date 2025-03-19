<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Referral extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'referrer_id',
        'referred_user_id',
        'status',
        'conversion_date',
    ];
    
    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'conversion_date' => 'datetime',
    ];
    
    /**
     * Get the user who referred someone.
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }
    
    /**
     * Get the user who was referred.
     */
    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }
    
    /**
     * Get the commission associated with this referral.
     */
    public function commission()
    {
        return $this->hasOne(Commission::class);
    }
    
    /**
     * Mark the referral as successful.
     */
    public function markAsSuccessful(): void
    {
        $this->status = 'successful';
        $this->conversion_date = now();
        $this->save();
        
        // Increment successful_referrals count for the referrer
        $referrerDetail = AffiliateDetail::where('user_id', $this->referrer_id)->first();
        if ($referrerDetail) {
            $referrerDetail->increment('successful_referrals');
            $referrerDetail->updateTierLevel(); // Update tier level if needed
        }
        
        // Create commission record (will be implemented in a service class)
    }

    public function getStatusDescriptionAttribute(): string
{
    return match($this->status) {
        'pending' => 'Registration Completed',
        'successful' => 'Made First Purchase',
        'failed' => 'Failed',
        default => ucfirst($this->status)
    };
}
}