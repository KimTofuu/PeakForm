<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutProgress extends Model
{
    protected $fillable = ['user_id', 'day', 'completed_exercises'];

    protected $casts = [
        'completed_exercises' => 'array',
    ];
}

