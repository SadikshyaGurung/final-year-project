<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
   protected $fillable = [
    'user_id',
    'symptoms',
    'prediction',
];

    public function symptomInput()
    {
        return $this->belongsTo(SymptomInput::class);
    }
}
