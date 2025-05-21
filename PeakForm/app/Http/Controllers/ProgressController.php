<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProgressEntry;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'date_recorded' => 'required|date',
            'weight' => 'required|numeric',
            'body_fat' => 'required|numeric',
            'muscle_mass' => 'required|numeric',
        ]);

        $user = Auth::user();

        // Adjust model/column names as needed
        ProgressEntry::create([
            'user_id' => $user->id,
            'date_recorded' => $request->recorded_at,
            'weight' => $request->weight,
            'body_fat_percentage' => $request->body_fat,
            'muscle_mass' => $request->muscle_mass,
        ]);

        return redirect()->back()->with('success', 'Progress entry added!');
    }

public function showProgressTab()
    {
        $user = Auth::user();

        // Fetch all progress entries for the authenticated user
        $progressEntries = ProgressEntry::where('user_id', $user->id)
                            ->orderBy('date_recorded', 'desc')
                            ->get();

        return view('progress_tab', compact('user', 'progressEntries'));
    }
}
