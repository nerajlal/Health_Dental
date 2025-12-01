<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'password_changed_at',
        'role',
        'phone',
        'address',
        'license_number',
        'business_registration',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'password_changed_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    // Relationships
    public function products()
    {
        return $this->hasMany(Product::class, 'distributor_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'clinic_id');
    }

    public function customPricing()
    {
        return $this->hasMany(CustomPricing::class, 'clinic_id');
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isClinic()
    {
        return $this->role === 'clinic';
    }

    public function isDistributor()
    {
        return $this->role === 'distributor';
    }

    public function needsPasswordReset()
    {
        return is_null($this->password_changed_at);
    }
}