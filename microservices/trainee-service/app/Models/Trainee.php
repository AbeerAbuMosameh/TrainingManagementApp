<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trainee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image',
        'first_name',
        'last_name',
        'email',
        'phone',
        'education',
        'gpa',
        'address',
        'city',
        'payment',
        'language',
        'cv',
        'certification',
        'otherFile',
        'is_approved',
        'password',
        'notification_id',
    ];

    protected $casts = [
        'gpa' => 'string',
        'otherFile' => 'array',
        'is_approved' => 'boolean',
        'notification_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Get the full name of the trainee
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
} 