<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\MealPlan;

class WorkoutController extends Controller
{
    public function generateSplit(Request $request){
        // Validate incoming data
        $data = $request->validate([
            'goal' => 'required|string|in:gain_muscle,lose_fat,maintenance',
            'intensity' => 'required|string|in:low,moderate,high',
            'setup' => 'required|string|in:full_gym,home',
            'days' => 'required|integer|min:3|max:6', 
            'level' => 'required|string|in:beginner,intermediate,advanced'
        ]);

        // Extract user inputs
        $goal = $data['goal'];
        $intensity = $data['intensity'];
        $setup = $data['setup'];
        $days = $data['days'];
        $level = $data['level'];

        // Generate workout split
        $workoutSplit = $this->createWorkoutPlan($goal, $intensity, $setup, $days, $level);

        // Return or save generated split
        return response()->json([
            'success' => true,
            'split' => $workoutSplit
        ]);
    }
    
    private function createWorkoutPlan($goal, $intensity, $setup, $days, $level){
        $split = [];
    
        if ($level === 'beginner') {
            // Goal-specific beginner splits
            if ($goal === 'gain_muscle') {
                $split = [
                    'Day 1' => 'Push (Chest, Shoulders, Triceps) - Beginner Hypertrophy Focus',
                    'Day 2' => 'Pull (Back, Biceps) - Beginner Strength Focus',
                    'Day 3' => 'Legs (Glutes, Quads, Hamstrings)',
                ];
                if ($days >= 4) $split['Day 4'] = 'Core + Mobility';
                if ($days >= 5) $split['Day 5'] = 'Push/Pull Mix + Cardio';
                if ($days == 6) $split['Day 6'] = 'Stretching or Light Cardio Recovery';
            }
    
            elseif ($goal === 'lose_fat') {
                $split = [
                    'Day 1' => 'Push (Chest, Shoulders, Triceps) + Light Cardio',
                    'Day 2' => 'Pull (Back, Biceps) + Core',
                    'Day 3' => 'Legs + HIIT Circuit',
                ];
                if ($days >= 4) $split['Day 4'] = 'Full Body Circuit Training';
                if ($days >= 5) $split['Day 5'] = 'Low-Impact Cardio + Abs';
                if ($days == 6) $split['Day 6'] = 'Stretch/Yoga Recovery';
            }
    
            else { // maintenance
                $split = [
                    'Day 1' => 'Push (Chest, Shoulders, Triceps) - Moderate Volume',
                    'Day 2' => 'Pull (Back, Biceps) - Moderate Volume',
                    'Day 3' => 'Legs + Core',
                ];
                if ($days >= 4) $split['Day 4'] = 'Cardio + Mobility';
                if ($days >= 5) $split['Day 5'] = 'Stretch + Core Stability';
                if ($days == 6) $split['Day 6'] = 'Active Recovery';
            }
    
            return $split;
        }
    
        // Intermediate/Advanced logic remains the same
        if ($goal === 'gain_muscle') {
            if ($setup === 'full_gym') {
                $split = [
                    'Day 1' => 'Upper A (Chest, Back, Shoulders)',
                    'Day 2' => 'Lower A (Quads, Hamstrings, Calves)',
                    'Day 3' => 'Upper B (Arms, Shoulders, Chest)',
                ];
                if ($days >= 4) $split['Day 4'] = 'Lower B (Glutes, Hamstrings, Calves)';
                if ($days >= 5) $split['Day 5'] = 'Push (Chest, Shoulders, Triceps)';
                if ($days == 6) $split['Day 6'] = 'Pull (Back, Biceps) / Cardio';
            } else {
                $split = [
                    'Day 1' => 'Bodyweight Push + Core',
                    'Day 2' => 'Bodyweight Pull + Cardio',
                    'Day 3' => 'Lower Body + Mobility',
                ];
                if ($days >= 4) $split['Day 4'] = 'Upper Body Circuits';
                if ($days >= 5) $split['Day 5'] = 'Lower Body HIIT';
                if ($days == 6) $split['Day 6'] = 'Active Recovery / Stretching';
            }
        } elseif ($goal === 'lose_fat') {
            if ($intensity === 'high') {
                $split = [
                    'Day 1' => 'HIIT + Full Body Strength',
                    'Day 2' => 'Cardio + Core',
                    'Day 3' => 'Lower Body HIIT',
                ];
                if ($days >= 4) $split['Day 4'] = 'Circuit Training';
                if ($days >= 5) $split['Day 5'] = 'Moderate Cardio + Core Focus';
                if ($days == 6) $split['Day 6'] = 'Active Recovery (Yoga/Stretching)';
            } else {
                $split = [
                    'Day 1' => 'Full Body Strength',
                    'Day 2' => 'Cardio + Core',
                    'Day 3' => 'Lower Body Focus',
                ];
                if ($days >= 4) $split['Day 4'] = 'Low-Impact HIIT';
                if ($days >= 5) $split['Day 5'] = 'Flexibility + Mobility';
                if ($days == 6) $split['Day 6'] = 'Active Recovery (Yoga/Stretching)';
            }
        } else {
            $split = [
                'Day 1' => 'Full Body Strength',
                'Day 2' => 'Light Cardio + Mobility',
                'Day 3' => 'Core & Flexibility',
            ];
            if ($days >= 4) $split['Day 4'] = 'Circuit/Moderate Training';
            if ($days >= 5) $split['Day 5'] = 'Low-Impact Cardio + Recovery';
            if ($days == 6) $split['Day 6'] = 'Stretching / Active Recovery';
        }
    
        return $split;
    }
        

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        
        $workSplit = "worksplitModel/table"::create([
            'PlanName' => $request->PlanName,
            'GoalType' => $request->GoalType,
            'SplitType' => $request->SplitType,
            'CreatedDate' => now(),
        ]);

        return response()->json($workSplit);
    }
}
