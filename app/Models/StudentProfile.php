<?php
// app/Models/StudentProfile.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentProfile extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_id';
    public $incrementing = false;
    
    protected $fillable = [
        'user_id',
        'college',
        'graduation_year',
        'branch',
        'skills',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}