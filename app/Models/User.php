<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'blocked_until',
        'block_reason',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'blocked_until' => 'datetime',
    ];

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is blocked.
     */
    public function isBlocked(): bool
    {
        if ($this->status === 'active') {
            return false;
        }
        
        if ($this->status === 'banned') {
            return true;
        }
        
        if ($this->status === 'blocked' && $this->blocked_until) {
            return now()->lt($this->blocked_until);
        }
        
        return false;
    }

    /**
     * Check if the user is an admin.
     */
    // public function isAdmin(): bool
    // {
    //     return $this->role === 'admin';
    // }
}
