<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvisorField extends Model
{
    use HasFactory;

    protected $fillable = ['advisor_id', 'field_id'];

    protected $table = 'advisor_fields';

    public function advisor()
    {
        return $this->belongsTo(Advisor::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}


