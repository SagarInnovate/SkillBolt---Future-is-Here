<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReferralClick extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     */
    protected $table = 'referral_clicks';
    
    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = false;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'referral_code',
        'ip_address',
        'user_agent',
        'source',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'created_at',
    ];
    
    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];
    
    /**
     * Get the affiliate details associated with the referral click.
     */
    public function affiliateDetail()
    {
        return $this->belongsTo(AffiliateDetail::class, 'referral_code', 'affiliate_code');
    }
}
