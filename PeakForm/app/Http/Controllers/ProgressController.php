<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgressEntry;
use App\Models\UserProgress;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkSplit;

class ProgressController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'date_recorded' => 'required|date',
            'weight' => 'nullable|numeric',
            'body_fat_percentage' => 'nullable|numeric',
            'muscle_mass' => 'nullable|numeric',
        ]);

        ProgressEntry::create([
            'user_id' => $user->id,
            'date_recorded' => $request->date_recorded,
            'weight' => $request->weight,
            'body_fat_percentage' => $request->body_fat_percentage,
            'muscle_mass' => $request->muscle_mass,
        ]);

        // Fetch the latest work split for this user
        $workSplit = WorkSplit::where('user_id', $user->id)->latest()->first();
        $goal = $workSplit ? strtolower(trim(str_replace('_', ' ', $workSplit->goal))) : null;
        // Determine which value to store as current_weight
        $current = null;
        // $goal_weight = null;
        if ($goal === 'gain muscle') {
            $current = $request->muscle_mass;
            // $goal_weight = $request->muscle_mass;
        } elseif ($goal === 'lose fat') {
            $current = $request->body_fat_percentage;
            // $goal_weight = $request->body_fat_percentage;
        } elseif ($goal === 'maintenance') {
            $current = $request->body_fat_percentage;
            // $goal_weight = $request->body_fat_percentage;
        } else {
            // fallback if goal is not set
            $current = $request->weight;
            // $goal_weight = $request->weight;
        }

        // Fetch the oldest progress entry for starting_weight
        $oldestProgress = ProgressEntry::where('user_id', $user->id)
            ->orderBy('date_recorded', 'asc')
            ->first();

        if ($goal === 'gain muscle') {
            $starting = $oldestProgress ? $oldestProgress->muscle_mass : $request->muscle_mass;
        } elseif ($goal === 'lose fat' || $goal === 'maintenance') {
            $starting = $oldestProgress ? $oldestProgress->body_fat_percentage : $request->body_fat_percentage;
        } else {
            $starting = $oldestProgress ? $oldestProgress->weight : $request->weight;
        }
        // Fetch the existing user_progress record (if any)
        $userProgress = UserProgress::where('user_id', $user->id)->first();
        $goal_weight = $userProgress ? $userProgress->goal_weight : 0; // fallback to 0 if not set

        // Only set starting if not already set
        UserProgress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'current' => $current,
                'goal_weight' => $goal_weight,
                'starting' => $userProgress && $userProgress->starting !== null ? $userProgress->starting : $starting,
            ]
        );

        return redirect()->back()->with('success', 'Progress entry added!');
    }

    public function showProgressTab()
    {
        $user = Auth::user();

        $progressEntries = ProgressEntry::where('user_id', $user->id)
            ->orderBy('date_recorded', 'desc')
            ->get();

        // Fetch goal from work split
        $workSplit = WorkSplit::where('user_id', $user->id)->latest()->first();
        $userGoal = $workSplit ? $workSplit->goal : null;

        // Fetch user_progress
        $userProgress = \App\Models\UserProgress::where('user_id', $user->id)->first();

        $progress = 0;
        $currentProgress = null;
        $goalValue = null;

        if ($userProgress && $userProgress->goal_weight !== null && $userProgress->starting !== null) {
            $starting = $userProgress->starting;
            $current = $userProgress->current;
            $goal = $userProgress->goal_weight;

            $currentProgress = $current;
            $goalValue = $goal;

            if ($goal != $starting) {
                // For fat loss, we want to decrease — invert logic
                $goalDirection = $goal < $starting ? -1 : 1;
                $progress = ($current - $starting) / ($goal - $starting) * 100;

                // If going backward (away from goal), clamp to 0%
                if ($goalDirection * ($current - $starting) < 0) {
                    $progress = 0;
                }

                // Cap at 100
                $progress = max(0, min(100, round($progress)));
            }
        }

        return view('progress_tab', compact(
            'user',
            'progressEntries',
            'userGoal',
            'progress',
            'currentProgress',
            'goalValue'
        ));
    }

    public function storeGoal(Request $request)
    {
        $user = Auth::user();

        // Fetch the oldest progress entry for starting
        $oldestProgress = ProgressEntry::where('user_id', $user->id)
            ->orderBy('date_recorded', 'asc')
            ->first();

        // Get the user's goal from the latest work split
        $workSplit = WorkSplit::where('user_id', $user->id)->latest()->first();
        $goal = $workSplit ? strtolower(trim(str_replace('_', ' ', $workSplit->goal))) : null;

        $goal_weight = null;
        if ($goal === 'gain muscle') {
            $request->validate(['goal_muscle_mass' => 'required|numeric']);
            $goal_weight = $request->input('goal_muscle_mass');
            $starting = $oldestProgress ? $oldestProgress->muscle_mass : $goal_weight;
        } elseif ($goal === 'lose fat') {
            $request->validate(['goal_body_fat_percentage' => 'required|numeric']);
            $goal_weight = $request->input('goal_body_fat_percentage');
            $starting = $oldestProgress ? $oldestProgress->body_fat_percentage : $goal_weight;
       } elseif ($goal === 'maintenance') {
            $request->validate(['goal_body_fat_percentage' => 'required|numeric']);
            $goal_weight = $request->input('goal_body_fat_percentage');
            $starting = $oldestProgress ? $oldestProgress->body_fat_percentage : $goal_weight;
        } else {
            $goal_weight = 0;
            $starting = $oldestProgress ? $oldestProgress->weight : 0;
        }

        // Fetch existing user_progress record (if any)
        $userProgress = UserProgress::where('user_id', $user->id)->first();
        // If no record exists, set current to starting (or goal_weight)
        $current = $userProgress ? $userProgress->current : $starting;

        UserProgress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'goal_weight' => $goal_weight,
                'starting' => $starting,
                'current' => $current, // Always provide current!
            ]
        );

        return redirect()->route('progress_tab')->with('success', 'Goal updated!');
    }
}
