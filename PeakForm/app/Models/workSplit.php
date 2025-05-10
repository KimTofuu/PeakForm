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
        'user_id',
        'WorkplanName',
        'splitType',
        'goal',
        'fitness_level',
        'equipment',
        'intensity',
        'setup',
        'days',
        'day1',
        'day2',
        'day3',
        'day4',
        'day5',
        'day6',
        'day7',
    ];
    

    public $timestamps = true;

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
