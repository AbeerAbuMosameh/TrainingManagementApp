<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'type',
        'price',
        'start_date',
        'end_date',
        'field_id',
        'advisor_id',
        'language',
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
} 