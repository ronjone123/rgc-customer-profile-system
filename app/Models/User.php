<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // 🔒 Role constants (GOOD PRACTICE)
    const ROLE_SUPERADMIN   = 'superadmin';
    const ROLE_HEAD_ADMIN   = 'head_admin';
    const ROLE_BRANCH_ADMIN = 'branch_admin';
    const ROLE_USER         = 'user';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'status',
    'branch_id', // ✅ REQUIRED
];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ======================
    // Role helper methods
    // ======================

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPERADMIN;
    }

    public function isHeadAdmin(): bool
    {
        return $this->role === self::ROLE_HEAD_ADMIN;
    }

    public function isBranchAdmin(): bool
    {
        return $this->role === self::ROLE_BRANCH_ADMIN;
    }

    public function isUser(): bool
    {
        return $this->role === self::ROLE_USER;
    }
    public function branch()
    {
        return $this->belongsTo(\App\Models\Branch::class);
    }
    
}
