<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MealPlan;
use App\Models\DailyIntake;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


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
            'protein' => round(($calories * $splits['protein']) / 5, 2),
            'carbs' => round(($calories * $splits['carbs']) / 4, 2),
            'fat' => round(($calories * $splits['fat']) / 9, 2),
        ];
    }

    public function getLatestMealPlan()
    {
        $user = Auth::user();

        $latestPlan = MealPlan::where('user_id', $user->id)->latest()->first();

        if ($latestPlan) {
            return response()->json([
                'success' => true,
                'meal_plan' => $latestPlan
            ]);
        }

        return response()->json(['success' => false, 'message' => 'No meal plan found.']);
    }

    public function updateIntake(Request $request)
    {
        $request->validate([
            'protein' => 'required|integer|min:0',
            'carbs' => 'required|integer|min:0',
            'fat' => 'required|integer|min:0',
        ]);

        $user = Auth::user();

        $today = now()->toDateString();

        $intake = DailyIntake::firstOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            ['protein' => 0, 'carbs' => 0, 'fat' => 0]
        );

        $intake->increment('protein', $request->protein);
        $intake->increment('carbs', $request->carbs);
        $intake->increment('fat', $request->fat);

        return response()->json([
            'success' => true,
            'data' => $intake
        ]);
    }

    public function getTodayIntake()
    {
        $user = Auth::user();

        $today = now()->toDateString();

        $intake = DailyIntake::where('user_id', $user->id)->where('date', $today)->first();

        return response()->json([
            'success' => true,
            'data' => $intake
        ]);
    }
    public function latestIntake(Request $request)
    {
        $user = Auth::user();
        $intake = DailyIntake::where('user_id', $user->id)->latest()->first();

        if ($intake) {
            return response()->json([
                'success' => true,
                'data' => [
                    'protein' => $intake->protein,
                    'carbs' => $intake->carbs,
                    'fat' => $intake->fat
                ]
            ]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    public function destroyToday()
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Step 1: Get today's daily intake records
        $intakes = DailyIntake::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->get();

        if ($intakes->isEmpty()) {
            return response()->json([
                'message' => 'No record found'
            ], 404);
        }

        // Step 2: Save them to the recorded_intakes table
        foreach ($intakes as $intake) {
            DB::table('recorded_intakes')->insert([
                'user_id' => $intake->user_id,
                'date' => $today->toDateString(),
                // 'calories' => $intake->calories,
                'protein' => $intake->protein,
                'carbs' => $intake->carbs,
                'fat' => $intake->fat,
                'created_at' => $intake->created_at,
                'updated_at' => now(),
            ]);
        }

        // Step 3: Delete from daily_intakes
        DailyIntake::where('user_id', $user->id)
            ->whereDate('created_at', $today)
            ->delete();

        return response()->json([
            'message' => 'Records moved and deleted successfully'
        ], 200);
    }

    public function showMealPlanTab()
    {
        $user = Auth::user();

        // Get today's intake
        $daily_intake = DailyIntake::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->first();

        return view('mealplan_tab', [
            'user' => $user,
            'daily_intake' => $daily_intake,
        ]);
    }
    public function showInOverview()
    {
        $user = Auth::user();

        // Get today's intake
        $daily_intake = DailyIntake::where('user_id', $user->id)
            ->whereDate('created_at', today())
            ->first();

        return view('overview_tab', [
            'user' => $user,
            'daily_intake' => $daily_intake,
        ]);
    }
}
