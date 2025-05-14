<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'gender' => 'required|string',
            'weight' => 'required|numeric|min:0',
            'height' => 'nullable|numeric|min:0',
            'goal' => 'nullable|string|max:255',
            'activityLevel' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->back()->withErrors(['error' => 'User not authenticated.']);
        }

        [$fname, $lname] = explode(' ', $request->name . ' ', 2);

        $user->update([
            'Fname' => $fname,
            'Lname' => trim($lname),
        ]);

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'age' => $request->age,
                'gender' => $request->gender,
                'weight' => $request->weight,
                'height' => $request->height,
                'goal' => $request->goal,
                'activityLevel' => $request->activityLevel,
            ]
        );

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
