<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model
{
    protected $fillable = [
        'user_id',
        'workout_plan', // assuming this is the column where JSON is stored
    ];
}
