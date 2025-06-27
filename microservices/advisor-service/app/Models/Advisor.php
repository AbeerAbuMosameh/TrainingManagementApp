<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advisor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image',
        'first_name',
        'last_name',
        'email',
        'phone',
        'education',
        'address',
        'city',
        'language',
        'cv',
        'certification',
        'otherFile',
        'is_approved',
        'password',
        'notification_id'
    ];

    protected $casts = [
        'is_approved' => 'boolean',
        'otherFile' => 'array',
    ];

    /**
     * Get the notification that owns the advisor.
     */
    public function notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }

    /**
     * Scope a query to only include approved advisors.
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope a query to filter by language.
     */
    public function scopeByLanguage($query, $language)
    {
        return $query->where('language', $language);
    }

    /**
     * Get the full name of the advisor.
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
