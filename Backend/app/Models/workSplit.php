<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class workSplit extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'UserID',
        'PlanName',
        'GoalType',
        'SplitType',
        'CreatedDate',
    ];

    public $timestamps = false;

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function workoutDays()
    {
        return $this->hasMany(workSplit::class, 'id');
    }
}
