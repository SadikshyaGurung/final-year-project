<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SymptomInput extends Model
{
    protected $fillable = [
        // Add your fillable fields here
    ];

    public function predictions()
    {
        return $this->hasMany(Prediction::class);
    }
}

