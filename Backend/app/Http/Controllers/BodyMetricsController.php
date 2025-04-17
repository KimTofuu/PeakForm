<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BodyMetric; // Assuming a model for body metrics exists

class BodyMetricsController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming data
        $data = $request->validate([
            'dateRecorded' => 'required|date',
            'weight' => 'required|numeric',
            'bodyFatPercentage' => 'required|numeric',
            'muscle_mass' => 'required|numeric',
        ]);

        // Create a new body metric record
        $bodyMetric = BodyMetric::create([
            'user_id' => Auth::id(), // Assuming a user is authenticated
            'dateRecorded' => $data['dateRecorded'],
            'weight' => $data['weight'],
            'bodyFatPercentage' => $data['bodyFatPercentage'],
            'muscle_mass' => $data['muscle_mass'],
        ]);

        return response()->json([
            'success' => true,
            'metric' => $bodyMetric
        ]);
    }
}