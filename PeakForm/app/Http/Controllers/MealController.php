<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MealPlan;

class MealController extends Controller
{
    public function generateMealPlan(Request $request)
    {
        $data = $request->validate([
            'age' => 'required|integer|min:13|max:80',
            'gender' => 'required|string|in:male,female',
            'weight' => 'required|numeric|min:30|max:200',
            'height' => 'required|numeric|min:120|max:250',
            'goal' => 'required|string|in:gain_muscle,lose_fat,maintenance',
            'activity' => 'required|numeric|between:1.2,1.9',
        ]);

        $bmr = $this->calculateBMR($data['gender'], $data['weight'], $data['height'], $data['age']);
        $tdee = $bmr * $data['activity'];
        $calories = $this->adjustCalories($tdee, $data['goal']);
        $macros = $this->calculateMacros($calories);

        $mealPlan = [
            'PlanName' => ucfirst(str_replace('_', ' ', $data['goal'])) . ' Meal Plan',
            'CalorieTarget' => round($calories),
            'ProteinTarget' => $macros['protein'],
            'CarbTarget' => $macros['carbs'],
            'FatTarget' => $macros['fat'],
        ];

        if ($user = Auth::user()) {
            MealPlan::create([
                'PlanName' => $mealPlan['PlanName'],
                'CalorieTarget' => $mealPlan['CalorieTarget'],
                'ProteinTarget' => $mealPlan['ProteinTarget'],
                'CarbTarget' => $mealPlan['CarbTarget'],
                'FatTarget' => $mealPlan['FatTarget'],
                'CreatedDate' => now(),
            ]);
        }

        return response()->json([
            'success' => true,
            'plan' => $mealPlan,
        ]);
    }

    private function calculateBMR($gender, $weight, $height, $age)
    {
        return ($gender === 'male')
            ? (10 * $weight + 6.25 * $height - 5 * $age + 5)
            : (10 * $weight + 6.25 * $height - 5 * $age - 161);
    }

    private function adjustCalories($tdee, $goal)
    {
        return match ($goal) {
            'gain_muscle' => $tdee + 300,
            'lose_fat' => $tdee - 500,
            default => $tdee,
        };
    }

    private function calculateMacros($calories)
    {
        $protein = round(($calories * 0.30) / 4, 2);
        $fat = round(($calories * 0.25) / 9, 2);
        $carbs = round(($calories * 0.45) / 4, 2);

        return compact('protein', 'carbs', 'fat');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'PlanName' => 'required|string',
            'CalorieTarget' => 'required|numeric',
            'ProteinTarget' => 'required|numeric',
            'CarbTarget' => 'required|numeric',
            'FatTarget' => 'required|numeric',
        ]);

        $mealPlan = MealPlan::create([
            'PlanName' => $request->PlanName,
            'CalorieTarget' => $request->CalorieTarget,
            'ProteinTarget' => $request->ProteinTarget,
            'CarbTarget' => $request->CarbTarget,
            'FatTarget' => $request->FatTarget,
            'CreatedDate' => now(),
        ]);

        return response()->json($mealPlan);
    }
}
