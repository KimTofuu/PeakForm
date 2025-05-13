<?php

namespace App\Http\Controllers;

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

        $mealPlan = $this->generateAndSaveMealPlan($data);

        return response()->json([
            'success' => true,
            'meal_plan' => $mealPlan,
        ]);
    }

    private function generateAndSaveMealPlan($data)
    {
        if (!Auth::check()) {
            abort(403, 'User not authenticated.');
        }

        $user = Auth::user();

        $bmr = $this->calculateBMR($data['gender'], $data['weight'], $data['height'], $data['age']);
        $tdee = $bmr * $data['activity'];
        $calories = $this->adjustCalories($tdee, $data['goal']);
        $macros = $this->calculateMacros($calories, $data['goal']);

        $mealPlanData = [
            'user_id' => $user->id,
            'MealplanName' => ucfirst(str_replace('_', ' ', $data['goal'])) . ' Meal Plan',
            'calorieTarget' => round($calories),
            'proteinTarget' => $macros['protein'],
            'carbsTarget' => $macros['carbs'],
            'fatTarget' => $macros['fat'],
            'bmr' => $bmr,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        return MealPlan::updateOrCreate(
            ['user_id' => $user->id],
            $mealPlanData
        );
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
        $splits = match ($goal) {
            'gain_muscle' => ['protein' => 0.30, 'carbs' => 0.50, 'fat' => 0.20],
            'lose_fat' => ['protein' => 0.40, 'carbs' => 0.30, 'fat' => 0.30],
            'maintenance' => ['protein' => 0.30, 'carbs' => 0.45, 'fat' => 0.25],
            default => ['protein' => 0.30, 'carbs' => 0.45, 'fat' => 0.25],
        };

        return [
            'protein' => round(($calories * $splits['protein']) / 4, 2),
            'carbs' => round(($calories * $splits['carbs']) / 4, 2),
            'fat' => round(($calories * $splits['fat']) / 9, 2),
        ];
    }

    public function showUserMealPlan()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $mealPlan = MealPlan::where('user_id', $user->id)->latest()->first();

        if (!$mealPlan) {
            return response()->json(['error' => 'Meal plan not found'], 404);
        }

        return response()->json([
            'success' => true,
            'meal_plan' => $mealPlan,
        ]);
    }
}
