<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_image',
        'contact_info',
        'account_status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user')
            ->withTimestamps('assigned_at');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_user')
            ->withPivot('status')
            ->wherePivot('status', 'active')
            ->withTimestamps('granted_at');
    }

    /**
     * Get the social accounts associated with the user.
     */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class);
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    public function isStudent()
    {
        return $this->hasRole('student');
    }

    public function isCompany()
    {
        return $this->hasRole('company');
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function hasPermission($permissionName)
    {
        return $this->permissions()->where('name', $permissionName)->exists();
    }

    public function canSell()
    {
        return $this->hasPermission('can_sell');
    }

    public function canAffiliate()
    {
        return $this->hasPermission('can_affiliate');
    }

    public function affiliateDetails()
    {
        return $this->hasOne(AffiliateDetail::class);
    }

/**
 * Get the referrals made by this user.
 */
    public function referrals()
    {
        return $this->hasMany(Referral::class, 'referrer_id');
    }

/**
 * Get the user who referred this user.
 */
    public function referredBy()
    {
        return $this->belongsTo(User::class, 'referred_by_user_id');
    }

/**
 * Get the commissions earned by this user.
 */
    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

/**
 * Get the payouts made to this user.
 */
    public function payouts()
    {
        return $this->hasMany(Payout::class);
    }

/**
 * Get the achievements earned by this user.
 */
public function achievements()
{
    return $this->belongsToMany(Achievement::class, 'user_achievements')
                ->withPivot('earned_at', 'is_notified')
                ->withTimestamps(); // This assumes you've added timestamps columns
}

/**
 * Check if user can request a payout.
 */
    public function canRequestPayout()
    {
        if (! $this->affiliateDetails) {
            return false;
        }

        $minThreshold = AffiliateSetting::get('min_payout_threshold', 1000);
        return $this->affiliateDetails->available_balance >= $minThreshold;
    }
}
