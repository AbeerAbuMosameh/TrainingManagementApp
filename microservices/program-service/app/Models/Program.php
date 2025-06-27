<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'image',
        'name',
        'hours',
        'start_date',
        'end_date',
        'type',
        'price',
        'number',
        'duration',
        'level',
        'language',
        'field_id',
        'description',
        'advisor_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'integer',
        'number' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function advisor()
    {
        // This would typically reference the advisor service
        // For now, we'll store the advisor_id as a reference
        return $this->belongsTo(Advisor::class);
    }
} 