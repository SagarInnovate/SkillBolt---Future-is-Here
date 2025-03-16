<?php
// app/Models/Waitlist.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    use HasFactory;
    
    protected $table = 'waitlist';

    protected $fillable = [
        'email',
        'name',
        'referral_code',
        'is_invited',
        'converted_user_id',
    ];

    public function convertedUser()
    {
        return $this->belongsTo(User::class, 'converted_user_id');
    }
}