<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MealPlan;




class MealController extends Controller
{
    public function generateMealPlan(Request $request)
    {
        // Validate incoming data
        $data = $request->validate([
            'age' => 'required|integer|min:13|max:80',
            'gender' => 'required|string|in:male,female',
            'weight' => 'required|numeric|min:30|max:200',
            'height' => 'required|numeric|min:120|max:250',
            'goal' => 'required|string|in:gain_muscle,lose_fat,maintenance',
            'activity' => 'required|numeric|between:1.2,1.9',
        ]);

        // Calculate BMR and TDEE
        $bmr = $this->calculateBMR($data);
        $tdee = $bmr * $data['activity'];

        // Adjust calories based on goal
        $calories = $this->adjustCalories($tdee, $data['goal']);

        // Calculate macros
        $macros = $this->calculateMacros($calories, $data['goal']);

        return response()->json([
            'success' => true,
            'calories' => round($calories),
            'macros' => $macros
        ]);
    }

    private function calculateBMR($data)
    {
        if ($data['gender'] === 'male') {
            return 10 * $data['weight'] + 6.25 * $data['height'] - 5 * $data['age'] + 5;
        } else {
            return 10 * $data['weight'] + 6.25 * $data['height'] - 5 * $data['age'] - 161;
        }
    }

    private function adjustCalories($tdee, $goal)
    {
        if ($goal === 'gain_muscle') {
            return $tdee + 300; // Calorie surplus for bulking
        } elseif ($goal === 'lose_fat') {
            return $tdee - 500; // Calorie deficit for cutting
        }
        return $tdee; // Maintenance calories
    }

    private function calculateMacros($calories, $goal)
    {
        $proteinCalories = ($calories * 0.3); // 30% calories from protein
        $fatCalories = ($calories * 0.25);    // 25% calories from fats
        $carbCalories = ($calories * 0.45);   // 45% calories from carbs

        return [
            'protein' => round($proteinCalories / 4, 2), // protein: 4 kcal per gram
            'carbs' => round($carbCalories / 4, 2),       // carbs: 4 kcal per gram
            'fat' => round($fatCalories / 9, 2)           // fat: 9 kcal per gram
        ];
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

        $mealPlan = "MealPlanModel/table"::create([
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
