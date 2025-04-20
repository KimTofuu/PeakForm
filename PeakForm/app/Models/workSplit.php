<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkSplit extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $table = 'work_splits';

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
