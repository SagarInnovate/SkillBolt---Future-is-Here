<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Achievement extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'description',
        'criteria',
        'badge_image',
        'points_value',
        'is_active',
    ];
    
    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'criteria' => 'json',
        'points_value' => 'integer',
        'is_active' => 'boolean',
    ];
    
    /**
     * The users that have earned this achievement.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements')
                    ->withPivot('earned_at', 'is_notified')
                    ->withTimestamps();
    }
    
    /**
     * Check if a user meets the criteria for this achievement.
     */
    public function checkCriteria(User $user): bool
    {
        // This will be implemented in an AchievementService
        return false;
    }
}