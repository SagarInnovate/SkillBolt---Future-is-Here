<?php
// app/Models/AffiliateDetail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateDetail extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'affiliate_code',
        'total_referrals',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}