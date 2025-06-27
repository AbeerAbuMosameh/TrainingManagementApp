<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'google_id',
        'unique_id',
        'level',
        'password',
        'email_verified_at',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'level' => 'integer',
        ];
    }

    /**
     * Get the user's role level
     */
    public function getRoleAttribute()
    {
        return match($this->level) {
            1 => 'admin',
            2 => 'advisor',
            3 => 'trainee',
            default => 'trainee'
        };
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->level === 1;
    }

    /**
     * Check if user is advisor
     */
    public function isAdvisor(): bool
    {
        return $this->level === 2;
    }

    /**
     * Check if user is trainee
     */
    public function isTrainee(): bool
    {
        return $this->level === 3;
    }
}
