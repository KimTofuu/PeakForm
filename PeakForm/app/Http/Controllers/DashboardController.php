<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Returns the dashboard view
    public function overview()
    {
        // Pass user info, or any other data needed
        return view('dashboard.overview');
    }

    // API endpoint returns JSON with progress data
    public function workoutSummary()
    {
        // Here you’d normally calculate these from the DB.
        // For demo, returning static example data:
        return response()->json([
            'daily_percent' => 60,
            'weekly_percent' => 45,
        ]);
    }
}
