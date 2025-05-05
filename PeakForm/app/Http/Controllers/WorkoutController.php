<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\WorkSplit;

class WorkoutController extends Controller
{
    public function generateSplit(Request $request){
        // Validate incoming data
        $data = [
            'goal' => session('workout_goal'),
            'intensity' => session('workout_intensity'),
            'setup' => session('workout_setup'),
            'days' => session('workout_days'),
            'level' => session('workout_level')
        ];
        
        $request->replace($data);

        // Extract user inputs
        $goal = $data['goal'];
        $intensity = $data['intensity'];
        $setup = $data['setup'];
        $days = $data['days'];
        $level = $data['level'];

        // Generate workout split
        $workoutSplit = $this->createWorkoutPlan($goal, $intensity, $setup, $days, $level);

        $user = Auth::user();
        if ($user) {
            WorkSplit::create([
                'user_id' => $user->id,
                'WorkplanName' => ucfirst(str_replace('_', ' ', $goal)) . ' Plan',
                // 'GoalType' => $goal,
                'splitType' => json_encode($workoutSplit),
                'CreatedDate' => now(),
            ]);            
        }

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

    public function updateStep(Request $request)
    {
        foreach ($request->all() as $key => $value) {
            if (in_array($key, ['goal', 'setup', 'intensity', 'level', 'days'])) {
                session(["workout_$key" => $value]);
            }
        }

        return redirect()->route('next_step'); // adjust dynamically
    }

    
    public function storeGoal(Request $request)
    {
        $request->validate([
            'goal' => 'required|string|in:gain_muscle,lose_fat,maintenance',
        ]);

        // Store the selected goal in session
        session(['workout_goal' => $request->goal]);

        // Redirect to the next step
        return redirect()->route('workout_plan_3');
    }

    public function storeSetup(Request $request)
    {
        $request->validate([
            'setup' => 'required|string|in:full_gym,home',
        ]);

        session(['workout_setup' => $request->setup]);

        return redirect()->route('workout_plan_4'); // next step
    }

    public function storeIntensity(Request $request)
    {
        $request->validate([
            'goal' => 'required|string|in:High Intensity,Moderate,Low Intensity',
        ]);

        // Optional: Map to normalized values
        $mappedIntensity = match($request->goal) {
            'High Intensity' => 'high',
            'Moderate' => 'moderate',
            'Low Intensity' => 'low',
            default => 'moderate', // fallback
        };

        session(['workout_intensity' => $mappedIntensity]);

        return redirect()->route('workout_plan_4');
    }

    public function storeDays(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:3|max:6',
        ]);

        session(['workout_days' => $request->days]);

        // Redirect to final step or dashboard
        return redirect()->route('dashboard_1'); // adjust if you're adding more steps
    }



    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        
        $workSplit = WorkSplit::create([
            'user_id' => $user->id,  // <-- optional if needed
            'PlanName' => $request->PlanName,
            'GoalType' => $request->GoalType,
            'SplitType' => $request->SplitType,
            'CreatedDate' => now(),
        ]);        

        return response()->json($workSplit);
    }
}
