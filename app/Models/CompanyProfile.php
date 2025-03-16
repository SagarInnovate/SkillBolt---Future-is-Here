<?php
// app/Models/CompanyProfile.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    
    protected $fillable = [
        'company_name',
        'industry',
        'size',
        'website',
        'verification_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}