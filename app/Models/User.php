<?php
// app/Models/User.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use  HasFactory, Notifiable, SoftDeletes;

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
        'password' => 'hashed',
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

    public function studentProfile()
    {
        return $this->hasOne(StudentProfile::class);
    }

    public function companyProfile()
    {
        return $this->hasOne(CompanyProfile::class);
    }

    public function affiliateDetails()
    {
        return $this->hasOne(AffiliateDetail::class);
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
}