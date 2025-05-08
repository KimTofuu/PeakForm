<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\WorkSplit;

class WorkoutController extends Controller
{
    private function generateAndSaveWorkout($data)
    {
        if (!Auth::check()) {
            abort(403, 'User not authenticated.');
        }
        
        $splitType = $data['splitType'];
        $days = $data['days'];

        $splitDays = $this->createWorkoutPlan($splitType, $days, $data);

        $user = Auth::user();
        if ($user) {
            WorkSplit::create([
                'user_id' => $user->id,
                'WorkplanName' => ucfirst(str_replace('_', ' ', $data['goal'])) . ' Plan',
                'splitType' => $splitType,
                'day1' => $splitDays['Day 1'] ?? null,
                'day2' => $splitDays['Day 2'] ?? null,
                'day3' => $splitDays['Day 3'] ?? null,
                'day4' => $splitDays['Day 4'] ?? null,
                'day5' => $splitDays['Day 5'] ?? null,
                'day6' => $splitDays['Day 6'] ?? null,
                'day7' => $splitDays['Day 7'] ?? null,
            ]);            
        }

        return $splitDays;
    }

    public function generateSplit(Request $request)
{
    $data = [
        'goal' => session('workout_goal'),
        'intensity' => session('workout_intensity'),
        'setup' => session('workout_setup'),
        'days' => session('workout_days'),
        'level' => session('workout_level'),
        'splitType' => session('workout_splitType'),
    ];

    $request->replace($data);

    $splitDays = $this->generateAndSaveWorkout($data);

    return response()->json([
        'success' => true,
        'split' => $splitDays,
    ]);
}

    
    
    // private function determineSplitType($goal, $intensity, $setup, $days, $level)
    // {
    //     if ($level === 'beginner') {
    //         return $days <= 3 ? 'Full Body' : 'Upper Lower';
    //     }
    
    //     if ($goal === 'gain_muscle' && $days >= 5) {
    //         return 'PPL'; // Push Pull Legs
    //     }
    
    //     return $days <= 3 ? 'Full Body' : 'Upper Lower';
    // }
    

    private function createWorkoutPlan($splitType, $days, $data)
{
    $level = $data['level'];
    $setup = $data['setup'];

    $plan = [
        'Day 1' => null,
        'Day 2' => null,
        'Day 3' => null,
        'Day 4' => null,
        'Day 5' => null,
        'Day 6' => null,
        'Day 7' => null,
    ];

    $homeExercises = [
        'beginner' => [
            'push' => ['Push-Ups', 'Overhead Dumbbell Press', 'Incline Pushups', 'Wall Pushups'],
            'pull' => ['Resistance Band Rows', 'Superman Pulls', 'Back Extensions', 'Doorway Rows'],
            'legs' => ['Bodyweight Squats', 'Lunges', 'Glute Bridges', 'Wall Sits'],
        ],
        'intermediate' => [
            'push' => ['Pike Push-Ups', 'Chair Dips', 'Handstand Holds', 'Resistance Band Press'],
            'pull' => ['Inverted Rows (Under Table)', 'Band Pull-Aparts', 'Towel Curls', 'Superman Pulls'],
            'legs' => ['Bulgarian Split Squats', 'Jump Squats', 'Wall Sits', 'Step-Ups'],
        ],
        'advanced' => [
            'push' => ['Handstand Push-Ups', 'Archer Push-Ups', 'Clap Push-Ups', 'Pseudo Planche Push-Ups'],
            'pull' => ['Towel Rows', 'Band Face Pulls', 'Door Pulls', 'Backpack Curls'],
            'legs' => ['Pistol Squats', 'Jump Lunges', 'Wall Sit Marches', 'Single-Leg Glute Bridges'],
        ],
    ];

    $gymExercises = [
        'beginner' => [
            'push' => ['Machine Chest Press', 'Overhead Dumbbell Press', 'Tricep Pushdowns', 'Incline Machine Press'],
            'pull' => ['Lat Pulldown', 'Cable Rows', 'EZ Bar Curls', 'Face Pulls'],
            'legs' => ['Leg Press', 'Seated Leg Curl', 'Glute Kickbacks', 'Calf Raises'],
        ],
        'intermediate' => [
            'push' => ['Bench Press', 'Shoulder Press', 'Tricep Extensions', 'Dumbbell Flys'],
            'pull' => ['Pull-Ups', 'Barbell Rows', 'Hammer Curls', 'Lat Pulldown'],
            'legs' => ['Squats', 'Leg Press', 'Deadlifts', 'Calf Raises'],
        ],
        'advanced' => [
            'push' => ['Incline Bench Press', 'Arnold Press', 'Skull Crushers', 'Cable Crossovers'],
            'pull' => ['Weighted Pull-Ups', 'T-Bar Rows', 'Preacher Curls', 'Cable Face Pulls'],
            'legs' => ['Front Squats', 'Romanian Deadlifts', 'Hack Squats', 'Hip Thrusts'],
        ],
    ];

    // Choose correct source based on setup
    $exerciseSource = ($setup === 'home') ? $homeExercises : $gymExercises;
    $lvl = $exerciseSource[$level] ?? $exerciseSource['beginner'];

    if ($splitType === 'PPL') {
        $plan['Day 1'] = $lvl['push'];
        $plan['Day 2'] = $lvl['pull'];
        $plan['Day 3'] = $lvl['legs'];
        if ($days >= 4) $plan['Day 4'] = $lvl['push'];
        if ($days >= 5) $plan['Day 5'] = $lvl['pull'];
        if ($days >= 6) $plan['Day 6'] = $lvl['legs'];
        if ($days >= 7) $plan['Day 7'] = ['Rest Day'];
    }

    elseif ($splitType === 'Upper Lower') {
        $upper = array_merge($lvl['push'], $lvl['pull']);
        $lower = $lvl['legs'];
        $plan['Day 1'] = array_slice($upper, 0, 4);
        $plan['Day 2'] = array_slice($lower, 0, 4);
        if ($days >= 3) $plan['Day 3'] = array_slice($upper, 2, 4);
        if ($days >= 4) $plan['Day 4'] = array_slice($lower, 2, 4);
        if ($days >= 5) $plan['Day 5'] = ['HIIT', 'Planks', 'Side Planks', 'Bird Dogs'];
        if ($days >= 6) $plan['Day 6'] = ['Mobility Work', 'Foam Rolling', 'Stretching'];
        if ($days >= 7) $plan['Day 7'] = ['Rest Day'];
    }

    elseif ($splitType === 'Full Body') {
        $combined = array_merge($lvl['push'], $lvl['pull'], $lvl['legs']);
        shuffle($combined);
        for ($i = 1; $i <= $days; $i++) {
            $plan["Day $i"] = array_slice($combined, ($i - 1) * 4, 4);
        }
    }

    // Trim extra days
    foreach ($plan as $day => $exercises) {
        preg_match('/\d+/', $day, $matches);
        $dayNumber = isset($matches[0]) ? (int)$matches[0] : 0;
        if ($dayNumber > $days) {
            unset($plan[$day]);
        }
    }

    return $plan;
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

        // dd($request->all());
        // Redirect to the next step
        return redirect()->route('workout_plan_2');
    }

    public function storeSetup(Request $request)
    {
        $request->validate([
            'setup' => 'required|string|in:full_gym,home',
        ]);

        session(['workout_setup' => $request->setup]);
        // dd($request->all());
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
        return redirect()->route('workout_plan_5'); 
    }

    public function storeLevel(Request $request)
    {
        $request->validate([
            'level' => 'required|string|in:beginner,intermediate,advanced',
        ]);

        session(['workout_level' => $request->level]);
        // dd($request->all());
        return redirect()->route('workout_plan_6'); 
    }

    public function storeSplitType(Request $request)
    {   
        $request->validate([
            'splitType' => 'required|string|in:PPL,Upper Lower,Full Body',
        ]);

        session(['workout_splitType' => $request->splitType]);

        $data = [
            'goal' => session('workout_goal'),
            'intensity' => session('workout_intensity'),
            'setup' => session('workout_setup'),
            'days' => session('workout_days'),
            'level' => session('workout_level'),
            'splitType' => session('workout_splitType'),
        ];

        $this->generateAndSaveWorkout($data); // automatically generate and store the plan

        return redirect()->route('overview_tab'); // user proceeds to next page
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        
        $workSplit = WorkSplit::create([
            'user_id' => $user->id,  // <-- optional if needed
            'workPlanName' => $request->PlanName,
            // 'GoalType' => $request->GoalType,
            'splitType' => $request->SplitType,
            'created_at' => now(),
        ]);        

        return response()->json($workSplit);
    }
}
