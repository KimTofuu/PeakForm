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
        $existingWorkSplit = WorkSplit::where('user_id', $user->id)
            ->where('WorkplanName', $splitType)  // or use another unique identifier
            ->first();

        if ($existingWorkSplit) {
            // Update existing record
            $existingWorkSplit->update([
                'day1' => json_encode($splitDays['Day 1'] ?? []),
                'day2' => json_encode($splitDays['Day 2'] ?? []),
                'day3' => json_encode($splitDays['Day 3'] ?? []),
                'day4' => json_encode($splitDays['Day 4'] ?? []),
                'day5' => json_encode($splitDays['Day 5'] ?? []),
                'day6' => json_encode($splitDays['Day 6'] ?? []),
                'day7' => json_encode($splitDays['Day 7'] ?? []),
            ]);
        } else {
            WorkSplit::where('user_id', $user->id)->delete();
            // Create new record
            WorkSplit::create([
                'user_id' => $user->id,
                'WorkplanName' => $splitType,
                'splitType' => $splitType,
                'goal' => $data['goal'],
                'fitness_level' => $data['level'],
                'equipment' => $data['setup'],
                'intensity' => $data['intensity'],
                'setup' => $data['setup'],
                'days' => $data['days'],
                'day1' => json_encode($splitDays['Day 1'] ?? []),
                'day2' => json_encode($splitDays['Day 2'] ?? []),
                'day3' => json_encode($splitDays['Day 3'] ?? []),
                'day4' => json_encode($splitDays['Day 4'] ?? []),
                'day5' => json_encode($splitDays['Day 5'] ?? []),
                'day6' => json_encode($splitDays['Day 6'] ?? []),
                'day7' => json_encode($splitDays['Day 7'] ?? []),
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

        // Prepare the data
        $data = [
            'goal' => session('workout_goal'),
            'intensity' => session('workout_intensity'),
            'setup' => session('workout_setup'),
            'days' => session('workout_days'),
            'level' => session('workout_level'),
            'splitType' => session('workout_splitType'),
        ];

        // Generate workout split and store
        $splitDays = $this->generateAndSaveWorkout($data);

        // Save user input data along with the workout split
        $user = Auth::user();
        if ($user) {
            $existingWorkSplit = WorkSplit::where('user_id', $user->id)->latest()->first();

            if ($existingWorkSplit) {
                $existingWorkSplit->update([
                    'WorkplanName' => $data['splitType'],
                    'splitType' => $data['splitType'],
                    'goal' => $data['goal'],
                    'fitness_level' => $data['level'],
                    'equipment' => $data['setup'],
                    'intensity' => $data['intensity'],
                    'setup' => $data['setup'],
                    'days' => $data['days'],
                    'day1' => json_encode($splitDays['Day 1'] ?? []),
                    'day2' => json_encode($splitDays['Day 2'] ?? []),
                    'day3' => json_encode($splitDays['Day 3'] ?? []),
                    'day4' => json_encode($splitDays['Day 4'] ?? []),
                    'day5' => json_encode($splitDays['Day 5'] ?? []),
                    'day6' => json_encode($splitDays['Day 6'] ?? []),
                    'day7' => json_encode($splitDays['Day 7'] ?? []),
                ]);
            } else {
                WorkSplit::where('user_id', $user->id)->delete();
                WorkSplit::create([
                    'user_id' => $user->id,
                    'WorkplanName' => $data['splitType'],
                    'splitType' => $data['splitType'],
                    'goal' => $data['goal'],
                    'fitness_level' => $data['level'],
                    'equipment' => $data['setup'],
                    'intensity' => $data['intensity'],
                    'setup' => $data['setup'],
                    'days' => $data['days'],
                    'day1' => json_encode($splitDays['Day 1'] ?? []),
                    'day2' => json_encode($splitDays['Day 2'] ?? []),
                    'day3' => json_encode($splitDays['Day 3'] ?? []),
                    'day4' => json_encode($splitDays['Day 4'] ?? []),
                    'day5' => json_encode($splitDays['Day 5'] ?? []),
                    'day6' => json_encode($splitDays['Day 6'] ?? []),
                    'day7' => json_encode($splitDays['Day 7'] ?? []),
                ]);
            }
        }

        return redirect()->route('overview_tab'); // user proceeds to next page
    }


    // public function store(Request $request)
    // {
    //     $user = Auth::user();
    //     if (!$user) {
    //         return response()->json(['error' => 'Unauthenticated'], 401);
    //     }
        
    //     $workSplit = WorkSplit::create([
    //         'user_id' => $user->id,  // <-- optional if needed
    //         'workPlanName' => $request->PlanName,
    //         // 'GoalType' => $request->GoalType,
    //         'splitType' => $request->SplitType,
    //         'created_at' => now(),
    //     ]);        

    //     return response()->json($workSplit);
    // }

    public function workoutsTab()
    {
        $user = Auth::user();
        $workSplit = WorkSplit::where('user_id', $user->id)->latest()->first();

        if (!$workSplit) {
            return view('workouts_tab', [
                'user' => $user,
                'workouts' => [],
                'input' => []
            ]);
        }

        $workouts = [
            'Monday' => json_decode($workSplit->day1 ?? '[]'),
            'Tuesday' => json_decode($workSplit->day2 ?? '[]'),
            'Wednesday' => json_decode($workSplit->day3 ?? '[]'),
            'Thursday' => json_decode($workSplit->day4 ?? '[]'),
            'Friday' => json_decode($workSplit->day5 ?? '[]'),
            'Saturday' => json_decode($workSplit->day6 ?? '[]'),
            'Sunday' => json_decode($workSplit->day7 ?? '[]'),
        ];

        return view('workouts_tab', [
            'user' => $user,
            'workouts' => $workouts,
            'input' => [
                'goal' => $workSplit->goal,
                'fitness_level' => $workSplit->fitness_level,
                'equipment' => $workSplit->equipment,
                'intensity' => $workSplit->intensity,
                'setup' => $workSplit->setup,
                'days' => $workSplit->days,
                'splitType' => $workSplit->splitType,
            ]
        ]);
    }


    public function edit()
    {
        $user = Auth::user();
        $workSplit = WorkSplit::where('user_id', $user->id)->latest()->first();

        return view('workouts.edit', [
            'user' => $user,
            'workSplit' => $workSplit,
        ]);
    }

    // private function generateSplitData($level, $goal, $days, $equipment)
    // {
    //     return $this->createWorkoutPlan('Full Body', $days, [
    //         'level' => $level,
    //         'goal' => $goal,
    //         'days' => $days,
    //         'setup' => $equipment,
    //         'splitType' => 'Full Body', // or determine dynamically
    //     ]);
    // }


    // public function update(Request $request)
    // {
    //     $user = Auth::user();

    //     $validated = $request->validate([
    //         'fitness_level' => 'required',
    //         'goal' => 'required',
    //         'days' => 'required|integer|min:1|max:7',
    //         'equipment' => 'required',
    //     ]);

    //     $newWorkout = $this->generateSplitData(
    //         $validated['fitness_level'],
    //         $validated['goal'],
    //         $validated['days'],
    //         $validated['equipment']
    //     );

    //     // Delete all existing workouts for the user
    //     WorkSplit::where('user_id', $user->id)->delete();

    //     // Create new workout
    //     WorkSplit::create([
    //         'user_id' => $user->id,
    //         'goal' => $validated['goal'],
    //         'fitness_level' => $validated['fitness_level'],
    //         'equipment' => $validated['equipment'],
    //         'setup' => $validated['equipment'], // if setup and equipment are the same
    //         'intensity' => 'moderate', // or pull from session/request if needed
    //         'days' => $validated['days'],
    //         'splitType' => 'Full Body',
    //         'WorkplanName' => 'Full Body',

    //         'day1' => json_encode($newWorkout['Day 1'] ?? []),
    //         'day2' => json_encode($newWorkout['Day 2'] ?? []),
    //         'day3' => json_encode($newWorkout['Day 3'] ?? []),
    //         'day4' => json_encode($newWorkout['Day 4'] ?? []),
    //         'day5' => json_encode($newWorkout['Day 5'] ?? []),
    //         'day6' => json_encode($newWorkout['Day 6'] ?? []),
    //         'day7' => json_encode($newWorkout['Day 7'] ?? []),
    //     ]);

    //     return redirect()->route('workouts_tab')->with('success', 'Workout updated successfully!');
    // }
}
