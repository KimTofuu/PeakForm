<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\WorkSplit;
use App\Models\WorkoutVideo;
use App\Models\Exercise;

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
        $goal = $data['goal'];
        $intensity = $data['intensity'];

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
                'pull' => ['Inverted Rows', 'Band Pull-Aparts', 'Towel Curls', 'Superman Pulls'],
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

        $repsSets = $this->getRepsAndSets($goal, $intensity);

        $wrapExercises = function($exerciseList) use ($repsSets) {
            return array_map(function($exercise) use ($repsSets) {
                // If already an array with a 'title' key, extract the string
                if (is_array($exercise) && isset($exercise['title'])) {
                    $title = $exercise['title'];
                    // Unwrap if nested
                    while (is_array($title) && isset($title['title'])) {
                        $title = $title['title'];
                    }
                    return [
                        'title' => $title,
                        'sets' => $repsSets['sets'],
                        'reps' => $repsSets['reps'],
                    ];
                }
                // Otherwise, use as string
                return [
                    'title' => $exercise,
                    'sets' => $repsSets['sets'],
                    'reps' => $repsSets['reps'],
                ];
            }, $exerciseList);
        };

        // Choose correct source based on setup
        $exerciseSource = ($setup === 'home') ? $homeExercises : $gymExercises;
        $lvl = $exerciseSource[$level] ?? $exerciseSource['beginner'];

        if ($splitType === 'PPL') {
            $plan['Day 1'] = $wrapExercises($lvl['push']);
            $plan['Day 2'] = $wrapExercises($lvl['pull']);
            $plan['Day 3'] = $wrapExercises($lvl['legs']);
            if ($days >= 4) $plan['Day 4'] = $wrapExercises($lvl['push']);
            if ($days >= 5) $plan['Day 5'] = $wrapExercises($lvl['pull']);
            if ($days >= 6) $plan['Day 6'] = $wrapExercises($lvl['legs']);
            if ($days >= 7) $plan['Day 7'] = ['Rest Day'];
        }

        elseif ($splitType === 'Upper Lower') {
            $upper = $wrapExercises(array_merge($lvl['push'], $lvl['pull']));
            $lower = $wrapExercises($lvl['legs']);
            $plan['Day 1'] = $wrapExercises(array_slice($upper, 0, 4));
            $plan['Day 2'] = $wrapExercises(array_slice($lower, 0, 4));
            if ($days >= 3) $plan['Day 3'] = $wrapExercises(array_slice($upper, 2, 4));
            if ($days >= 4) $plan['Day 4'] = $wrapExercises(array_slice($lower, 2, 4));
            if ($days >= 5) $plan['Day 5'] = $wrapExercises(['Leg Raises', 'Planks', 'Side Planks', 'Bird Dogs']);
            if ($days >= 6) $plan['Day 6'] = $wrapExercises(['Mobility Work', 'Foam Rolling', 'Stretching']);
            if ($days >= 7) $plan['Day 7'] = ['Rest Day'];
        }

        elseif ($splitType === 'Full Body') {
            $combined = $wrapExercises(array_merge($lvl['push'], $lvl['pull'], $lvl['legs']));
            shuffle($combined);

            $exerciseCount = count($combined);

            for ($i = 1; $i <= $days; $i++) {
                $start = (($i - 1) * 4) % $exerciseCount;
                $dayExercises = $wrapExercises(array_slice($combined, $start, 4));

                // If slice goes beyond array end, wrap around
                if (count($dayExercises) < 4) {
                    $dayExercises = $wrapExercises(array_merge($dayExercises, array_slice($combined, 0, 4 - count($dayExercises))));
                }

                $plan["Day $i"] = $dayExercises;
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

        return redirect()->route('workout-preview'); // user proceeds to next page
    }

    public function workoutsTab()
    {
        $user = Auth::user();
        $workSplit = WorkSplit::where('user_id', $user->id)->latest()->first();

        if (!$workSplit) {
            return view('workouts_tab', [
                'user' => $user,
                'workouts' => [],
                'input' => [],
                'videoList' => collect(),
            ]);
        }

        $workouts = [
            'Monday' => json_decode($workSplit->day1 ?? '[]', true),
            'Tuesday' => json_decode($workSplit->day2 ?? '[]', true),
            'Wednesday' => json_decode($workSplit->day3 ?? '[]', true),
            'Thursday' => json_decode($workSplit->day4 ?? '[]', true),
            'Friday' => json_decode($workSplit->day5 ?? '[]', true),
            'Saturday' => json_decode($workSplit->day6 ?? '[]', true),
            'Sunday' => json_decode($workSplit->day7 ?? '[]', true),
        ];

        $videoList = WorkoutVideo::all()->keyBy(function ($item) {
            return strtolower(trim($item->title));
        });

         // Attach muscle_group to each exercise
        foreach ($workouts as &$day) {
            foreach ($day as &$exercise) {
                if (is_array($exercise) && isset($exercise['title'])) {
                    $title = $exercise['title'];
                    // Keep unwrapping until $title is not an array
                    while (is_array($title) && isset($title['title'])) {
                        $title = $title['title'];
                    }
                    if (is_string($title)) {
                        $normalized = strtolower(trim($title));
                        if (isset($videoList[$normalized]) && isset($videoList[$normalized]->muscle_group)) {
                            $exercise['muscle_group'] = $videoList[$normalized]->muscle_group;
                        }
                    } else {
                        // fallback if title is still not a string
                        $exercise['muscle_group'] = null;
                    }
                }
            }
        }
        unset($day, $exercise); // break reference

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
            ],
            'videoList' => $videoList,
        ]);
    }

    public function workoutPreview()
    {
        $user = Auth::user();
        $workSplit = WorkSplit::where('user_id', $user->id)->latest()->first();

        if (!$workSplit) {
            return view('workout-preview', [
                'user' => $user,
                'workouts' => [],
                'input' => [],
                'videoList' => collect(),
            ]);
        }

        $workouts = [
            'Monday' => json_decode($workSplit->day1 ?? '[]', true),
            'Tuesday' => json_decode($workSplit->day2 ?? '[]', true),
            'Wednesday' => json_decode($workSplit->day3 ?? '[]', true),
            'Thursday' => json_decode($workSplit->day4 ?? '[]', true),
            'Friday' => json_decode($workSplit->day5 ?? '[]', true),
            'Saturday' => json_decode($workSplit->day6 ?? '[]', true),
            'Sunday' => json_decode($workSplit->day7 ?? '[]', true),
        ];

        $videoList = WorkoutVideo::all()->keyBy(function ($item) {
            return strtolower(trim($item->title));
        });

        return view('workout-preview', [
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
            ],
            'videoList' => $videoList,
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

    public function getWorkoutForDay(Request $request)
    {
        $user = Auth::user();
        // $day = $request->query('day', 1);

        $workSplit = WorkSplit::where('user_id', $user->id)->latest()->first();

        // $field = 'day' . $day;
        // $exercises = json_decode($workSplit->{$field} ?? '[]', true);

        

        $videoList = WorkoutVideo::all()->keyBy(function ($item) {
            return strtolower(trim($item->title));
        });

        $workouts = [
            'Monday' => json_decode($workSplit->day1 ?? '[]', true),
            'Tuesday' => json_decode($workSplit->day2 ?? '[]', true),
            'Wednesday' => json_decode($workSplit->day3 ?? '[]', true),
            'Thursday' => json_decode($workSplit->day4 ?? '[]', true),
            'Friday' => json_decode($workSplit->day5 ?? '[]', true),
            'Saturday' => json_decode($workSplit->day6 ?? '[]', true),
            'Sunday' => json_decode($workSplit->day7 ?? '[]', true),
        ];

        $input = [
            'goal' => $workSplit->goal,
            'fitness_level' => $workSplit->fitness_level,
            'equipment' => $workSplit->equipment,
            'intensity' => $workSplit->intensity,
            'setup' => $workSplit->setup,
            'days' => $workSplit->days,
            'splitType' => $workSplit->splitType,
        ];
        
        return view('workouts_tab', [
            'user' => $user,
            'workouts' => $workouts,
            'input' => $input,
            'videoList' => $videoList,
        ]);

        // foreach ($exercises as $exercise) {
        //     $title = strtolower(trim($exercise));
        //     if ($videoList->has($title)) {
        //         $final[] = [
        //             'title' => $exercise,
        //             'video_url' => $videoList[$title]->video_url,
        //         ];
        //     } else {
        //         $final[] = [
        //             'title' => $exercise,
        //             'not_found' => true,
        //         ];
        //     }
        // }

        // return response()->json([
        //     'success' => true,
        //     'exercises' => $final,
        // ]);
    }

     public function getWorkoutForOverview(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated.'], 403);
        }

        $dayNumber = $request->input('day');
        $workSplit = WorkSplit::where('user_id', $user->id)->latest()->first();

        if (!$workSplit) {
            return response()->json(['error' => 'No workout plan found.'], 404);
        }

        $days = [
            'Day 1' => json_decode($workSplit->day1 ?? '[]', true),
            'Day 2' => json_decode($workSplit->day2 ?? '[]', true),
            'Day 3' => json_decode($workSplit->day3 ?? '[]', true),
            'Day 4' => json_decode($workSplit->day4 ?? '[]', true),
            'Day 5' => json_decode($workSplit->day5 ?? '[]', true),
            'Day 6' => json_decode($workSplit->day6 ?? '[]', true),
            'Day 7' => json_decode($workSplit->day7 ?? '[]', true),
        ];

        $videoList = WorkoutVideo::all()->keyBy(function ($item) {
            return strtolower(trim($item->title));
        });

        $selectedDay = "Day $dayNumber";
        $rawExercises = $days[$selectedDay];

        // Attach muscle_group to each exercise
        $formattedExercises = collect($rawExercises)->map(function ($exercise) use ($videoList) {
            if (is_string($exercise)) {
                return ['title' => $exercise, 'sets' => null, 'reps' => null, 'muscle_group' => null];
            }
            if (is_array($exercise) && isset($exercise['title'])) {
                $title = $exercise['title'];
                while (is_array($title) && isset($title['title'])) {
                    $title = $title['title'];
                }
                if (is_string($title)) {
                    $normalized = strtolower(trim($title));
                    $exercise['muscle_group'] = isset($videoList[$normalized]) ? $videoList[$normalized]->muscle_group : null;
                } else {
                    $exercise['muscle_group'] = null;
                }
            }
            return $exercise;
        })->values();

        return response()->json([
            'success' => true,
            'day' => $selectedDay,
            'exercises' => $formattedExercises,
        ]);
    }

    private function getRepsAndSets($goal, $intensity)
    {
        $base = [
            'build muscle' => ['sets' => 4, 'reps' => 10],
            'fat loss' => ['sets' => 3, 'reps' => 15],
            'strength' => ['sets' => 5, 'reps' => 5],
        ];

        $adjustment = [
            'low' => 0,
            'medium' => 1,
            'high' => 2,
        ];

        $sets = ($base[$goal]['sets'] ?? 3) + ($adjustment[$intensity] ?? 0);
        $reps = ($base[$goal]['reps'] ?? 10) - ($adjustment[$intensity] ?? 0);

        return ['sets' => $sets, 'reps' => $reps];
    }
}
