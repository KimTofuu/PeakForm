<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MealPlan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'MealplanName',
        'calorieTarget',
        'proteinTarget',
        'carbsTarget',
        'fatTarget',
        'bmr',
        'created_at',
        'updated_at',
    ];

    public $timestamps = false;

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function mealPlans()
    {
        return $this->hasMany(MealPlan::class, 'id');
    }
}
