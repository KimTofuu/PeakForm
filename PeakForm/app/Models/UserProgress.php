<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProgress extends Model
{
    // Specify the table name since it's not the default 'user_progresses'
    protected $table = 'user_progress';

    // Add fillable fields for mass assignment
    protected $fillable = [
        'user_id',
        'starting',
        'current',
        'goal_weight',
    ];

    // Relationship to User (optional, but recommended)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
