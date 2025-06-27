<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'program_id',
        'advisor_id',
        'start_date',
        'end_date',
        'mark',
        'description',
        'related_file',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'mark' => 'integer',
        'related_file' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the program that owns the task
     */
    public function program()
    {
        // This would reference the program service
        // For now, we'll store the program_id as a reference
        return $this->belongsTo(Program::class);
    }

    /**
     * Get the advisor that owns the task
     */
    public function advisor()
    {
        // This would reference the advisor service
        // For now, we'll store the advisor_id as a reference
        return $this->belongsTo(Advisor::class);
    }
} 