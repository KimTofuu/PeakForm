<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodyMetric extends Model
{
    protected $fillable = [
        'user_id',
        'dateRecorded',
        'weight',
        'bodyFatPercentage',
        'muscle_mass',
    ];
}
