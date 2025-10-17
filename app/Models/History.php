<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User; // <-- add this

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'symptoms',
        'result',
    ];

    protected $casts = [
        'symptoms' => 'array',
        'result' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
