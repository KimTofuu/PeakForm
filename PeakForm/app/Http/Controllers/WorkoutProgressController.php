<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkoutProgress;
use App\Models\WorkSplit;
use App\Models\Workout;

class WorkoutProgressController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $day = $request->query('day');

        $progress = WorkoutProgress::where('user_id', $user->id)->where('day', $day)->first();
        return response()->json([
            'success' => true,
            'completed' => $progress?->completed_exercises ?? [],
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'day' => 'required|integer|min:1|max:7',
            'exercises' => 'required|array',
        ]);

        $user = $request->user();

        $progress = WorkoutProgress::updateOrCreate(
            ['user_id' => $user->id, 'day' => $request->day],
            ['completed_exercises' => $request->exercises]
        );

        return response()->json(['success' => true]);
    }
    public function summary(Request $request)
    {
        $user = $request->user();
        $today = now()->dayOfWeekIso; // 1 = Monday ... 7 = Sunday
        $column = 'day' . $today;

        // Get today's workout
        $split = WorkSplit::where('user_id', $user->id)->first();
        $todayExercises = $split ? $split->$column : [];

        // Get all progress records this week
        $progress = WorkoutProgress::where('user_id', $user->id)->get();
        $todayProgress = $progress->firstWhere('day', $today);
        $completedToday = $todayProgress->completed_exercises ?? [];

        // Count how many days have at least 1 completed exercise
        $weeklyCompletedDays = $progress->filter(fn($p) => count($p->completed_exercises ?? []) > 0)->count();

        $dailyPercent = count($todayExercises) > 0
            ? round((count($completedToday) / count($todayExercises)) * 100)
            : 0;

        $weeklyPercent = round(($weeklyCompletedDays / 7) * 100);

        return response()->json([
            'success' => true,
            'daily_percent' => $dailyPercent,
            'weekly_percent' => $weeklyPercent,
        ]);
    }
}
