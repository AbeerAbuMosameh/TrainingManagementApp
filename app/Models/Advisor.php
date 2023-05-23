<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advisor extends Model
{
    use HasFactory, SoftDeletes;

    public function notification()
    {
        return $this->belongsTo(Notification::class);
    }
}
