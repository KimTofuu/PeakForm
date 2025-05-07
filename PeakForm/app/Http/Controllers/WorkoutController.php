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
    

    private function createWorkoutPlan($splitType, $days)
    {
        $plan = [
            'Day 1' => null,
            'Day 2' => null,
            'Day 3' => null,
            'Day 4' => null,
            'Day 5' => null,
            'Day 6' => null,
            'Day 7' => null,
        ];

        if ($splitType === 'Full Body') {
            // Define base exercises for Full Body workouts
            $plan['Day 1'] = ['Squats', 'Push-Ups', 'Dumbbell Rows', 'Plank'];
            $plan['Day 2'] = ['Jumping Jacks', 'Lunges', 'Dips', 'Mountain Climbers'];
            $plan['Day 3'] = ['Deadlifts', 'Bench Press', 'Pull-Ups', 'Leg Raises'];

            if ($days >= 4) {
                $plan['Day 4'] = ['Yoga Flow', 'Stretching', 'Foam Rolling'];
            }
            if ($days >= 5) {
                $plan['Day 5'] = ['Circuit Training', 'Burpees', 'High Knees', 'Core Twist'];
            }
            if ($days >= 6) {
                $plan['Day 6'] = ['Active Recovery', 'Walking', 'Core Exercises', 'Stability Ball Work'];
            }
            if ($days >= 7) {
                $plan['Day 7'] = ['Rest Day'];
            }
        }

        elseif ($splitType === 'Upper Lower') {
            // Define exercises for Upper Lower split
            $plan['Day 1'] = ['Bench Press', 'Incline Dumbbell Press', 'Chest Flys', 'Tricep Pushdown'];
            $plan['Day 2'] = ['Squats', 'Leg Press', 'Walking Lunges', 'Calf Raises'];
            $plan['Day 3'] = ['Pull-Ups', 'Bent Over Rows', 'Bicep Curls', 'Face Pulls'];

            if ($days >= 4) {
                $plan['Day 4'] = ['Deadlifts', 'Hamstring Curls', 'Glute Bridges', 'Core Stability'];
            }
            if ($days >= 5) {
                $plan['Day 5'] = ['Shoulder Press', 'Lateral Raises', 'Front Raises', 'Tricep Extensions'];
            }
            if ($days >= 6) {
                $plan['Day 6'] = ['Core Exercises', 'Plank Variations', 'Russian Twists', 'Leg Raises'];
            }
            if ($days >= 7) {
                $plan['Day 7'] = ['Rest Day'];
            }
        }

        elseif ($splitType === 'PPL') {
            // Define exercises for a Push/Pull/Legs split
            $plan['Day 1'] = ['Bench Press', 'Shoulder Press', 'Tricep Dips', 'Push-Ups']; // Push
            $plan['Day 2'] = ['Pull-Ups', 'Barbell Rows', 'Bicep Curls', 'Face Pulls'];   // Pull
            $plan['Day 3'] = ['Squats', 'Leg Press', 'Calf Raises', 'Glute Bridges'];      // Legs

            if ($days >= 4) {
                $plan['Day 4'] = ['Incline Bench Press', 'Lateral Raises', 'Skull Crushers', 'Cable Flys']; // Push variation
            }
            if ($days >= 5) {
                $plan['Day 5'] = ['Chin-Ups', 'Hammer Curls', 'Reverse Flys', 'Single Arm Row'];          // Pull variation
            }
            if ($days >= 6) {
                $plan['Day 6'] = ['Lunges', 'Leg Curls', 'Stiff Leg Deadlifts', 'Goblet Squats'];           // Legs variation
            }
            if ($days >= 7) {
                $plan['Day 7'] = ['Rest Day'];
            }
        }
        
        // Optionally trim the plan to only include the number of days requested.
        // For example, if $days is less than 7, you could unset extra keys:
        foreach ($plan as $day => $exercises) {
            // Extract the day number from "Day X"
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
        return redirect()->route('overview_tab'); 
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
