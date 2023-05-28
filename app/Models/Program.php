<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory , SoftDeletes;

    protected $guarded=[];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }

    public function trainees()
    {
        return $this->belongsToMany(Trainee::class, 'trainee_program');
    }
}
