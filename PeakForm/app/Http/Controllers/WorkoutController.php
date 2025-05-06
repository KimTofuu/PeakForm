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


        $splitType = $this->determineSplitType($goal, $intensity, $setup, $days, $level);
        $splitDays = $this->createWorkoutPlan($splitType, $days);

        $user = Auth::user();
        if ($user) {
            WorkSplit::create([
                'user_id' => $user->id,
                'PlanName' => ucfirst(str_replace('_', ' ', $goal)) . ' Plan',
                'SplitType' => $splitType,
                'day1' => $splitDays['Day 1'] ?? null,
                'day2' => $splitDays['Day 2'] ?? null,
                'day3' => $splitDays['Day 3'] ?? null,
                'day4' => $splitDays['Day 4'] ?? null,
                'day5' => $splitDays['Day 5'] ?? null,
                'day6' => $splitDays['Day 6'] ?? null,
                'day7' => $splitDays['Day 7'] ?? null,
            ]);
        }


        // Return or save generated split
        return response()->json([
            'success' => true,
            'split' => $splitDays
        ]);
    }
    
    private function determineSplitType($goal, $intensity, $setup, $days, $level)
    {
        if ($level === 'beginner') {
            return $days <= 3 ? 'Full Body' : 'Upper Lower';
        }
    
        if ($goal === 'gain_muscle' && $days >= 5) {
            return 'PPL'; // Push Pull Legs
        }
    
        return $days <= 3 ? 'Full Body' : 'Upper Lower';
    }
    

    private function createWorkoutPlan($splitType, $days){
        $split = [];
    
        if ($splitType === 'Full Body') {
            return [
                'Day 1' => 'Full Body Strength',
                'Day 2' => 'Cardio + Core',
                'Day 3' => 'Full Body HIIT',
                'Day 4' => $days >= 4 ? 'Mobility + Recovery' : null,
                'Day 5' => $days >= 5 ? 'Full Body Circuit' : null,
                'Day 6' => $days >= 6 ? 'Stretch/Yoga' : null,
            ];
        }
        
        if ($splitType === 'Upper Lower') {
            return [
                'Day 1' => 'Upper Body A (Chest, Back, Shoulders)',
                'Day 2' => 'Lower Body A (Glutes, Quads)',
                'Day 3' => 'Upper Body B (Arms, Chest)',
                'Day 4' => $days >= 4 ? 'Lower Body B (Hamstrings, Calves)' : null,
                'Day 5' => $days >= 5 ? 'Core + Cardio' : null,
                'Day 6' => $days >= 6 ? 'Mobility / Recovery' : null,
            ];
        }
        
        if ($splitType === 'PPL') {
            return [
                'Day 1' => 'Push (Chest, Shoulders, Triceps)',
                'Day 2' => 'Pull (Back, Biceps)',
                'Day 3' => 'Legs (Quads, Hamstrings, Glutes)',
                'Day 4' => $days >= 4 ? 'Push (Hypertrophy)' : null,
                'Day 5' => $days >= 5 ? 'Pull (Volume)' : null,
                'Day 6' => $days >= 6 ? 'Legs (Strength)' : null,
            ];
        }
        
        return []; // fallback        
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
        return redirect()->route('workout_plan_2');
    }

    public function storeSetup(Request $request)
    {
        $request->validate([
            'setup' => 'required|string|in:full_gym,home',
        ]);

        session(['workout_setup' => $request->setup]);
        return redirect()->route('workout_plan_3'); // next step
    }

    public function storeIntensity(Request $request)
    {
        $request->validate([
            'intensity' => 'required|string|in:high,moderate,low',
        ]);

        session(['workout_intensity' => $request->intensity]);
        // dd($request->all());
        return redirect()->route('workout_plan_4');
    }



    public function storeDays(Request $request)
    {
        $request->validate([
            'days' => 'required|integer|min:1|max:6',
        ]);

        session(['workout_days' => $request->days]);
        // dd($request->all());
        // Redirect to final step or dashboard
        return redirect()->route('overview_tab'); // adjust if you're adding more steps
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
