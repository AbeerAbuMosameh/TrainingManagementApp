<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded=[];

    public function tasks()
    {
        return $this->hasManyThrough(Task::class, Program::class);
    }
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function trainees()
    {
        return $this->belongsToMany(Trainee::class, 'training_programs');
    }

}
