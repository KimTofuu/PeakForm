<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MealPlan extends Model
{
    use HasFactory;

    protected $primaryKey = 'MealPlanID';

    protected $fillable = [
        'UserID',
        'PlanName',
        'CalorieTarget',
        'ProteinTarget',
        'CarbTarget',
        'FatTarget',
        'CreatedDate',
    ];

    public $timestamps = false;

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function mealPlans()
    {
        return $this->hasMany(MealPlan::class, 'MealPlanID');
    }
}
