<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutVideo extends Model
{
    protected $fillable = [
        'title',
        'description',
        'youtube_url',
        'muscle_group',
        'duration',
        'thumbnail_url',
    ];
}