<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyIntake extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'protein',
        'carbs',
        'fat',
    ];

    // Optional: define the relationship to the User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
