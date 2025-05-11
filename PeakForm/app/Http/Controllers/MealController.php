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
        $macros = $this->calculateMacros($calories, $data['goal']);

        $mealPlan = [
            'MealplanName' => ucfirst(str_replace('_', ' ', $data['goal'])) . ' Meal Plan',
            'calorieTarget' => round($calories),
            'proteinTarget' => $macros['protein'],
            'carbsTarget' => $macros['carbs'],
            'fatTarget' => $macros['fat'],
            'bmr' => $bmr,
        ];

        if ($user = Auth::user()) {
            // Check if a meal plan already exists for the user
            $existingMealPlan = MealPlan::where('user_id', $user->id)->latest()->first();

            if ($existingMealPlan) {
                // Update existing record
                $existingMealPlan->update([
                    'MealplanName' => $mealPlan['MealplanName'],
                    'calorieTarget' => $mealPlan['calorieTarget'],
                    'proteinTarget' => $mealPlan['proteinTarget'],
                    'carbsTarget' => $mealPlan['carbsTarget'],
                    'fatTarget' => $mealPlan['fatTarget'],
                    'bmr' => $bmr,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                // Create a new record
                MealPlan::create([
                    'user_id' => $user->id,
                    'MealplanName' => $mealPlan['MealplanName'],
                    'calorieTarget' => $mealPlan['calorieTarget'],
                    'proteinTarget' => $mealPlan['proteinTarget'],
                    'carbsTarget' => $mealPlan['carbsTarget'],
                    'fatTarget' => $mealPlan['fatTarget'],
                    'bmr' => $bmr,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
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

    private function calculateMacros($calories, $goal)
    {
        // Macronutrient distribution by goal
        $splits = match ($goal) {
            'gain_muscle' => ['protein' => 0.30, 'carbs' => 0.50, 'fat' => 0.20],
            'lose_fat' => ['protein' => 0.40, 'carbs' => 0.30, 'fat' => 0.30],
            'maintenance' => ['protein' => 0.30, 'carbs' => 0.45, 'fat' => 0.25],
            default => ['protein' => 0.30, 'carbs' => 0.45, 'fat' => 0.25],
        };

        $protein = round(($calories * $splits['protein']) / 4, 2);
        $carbs = round(($calories * $splits['carbs']) / 4, 2);
        $fat = round(($calories * $splits['fat']) / 9, 2);

        return compact('protein', 'carbs', 'fat');
    }


    // public function store(Request $request)
    // {
    //     $user = Auth::user();

    //     if (!$user) {
    //         return response()->json(['error' => 'Unauthenticated'], 401);
    //     }

    //     $request->validate([
    //         'MealplanName' => 'required|string',
    //         'calorieTarget' => 'required|numeric',
    //         'proteinTarget' => 'required|numeric',
    //         'carbsTarget' => 'required|numeric',
    //         'FatTarget' => 'required|numeric',
    //     ]);

    //     $mealPlan = MealPlan::create([
    //         'user_id' => $user->id,
    //         'MealplanName' => $request->MealplanName,
    //         'calorieTarget' => $request->calorieTarget,
    //         'proteinTarget' => $request->proteinTarget,
    //         'carbsTarget' => $request->carbsTarget,
    //         'fatTarget' => $request->fatTarget,
    //     ]);

    //     return response()->json($mealPlan);
    // }
}
