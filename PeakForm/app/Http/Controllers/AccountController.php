<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\MealPlan;
use App\Models\Profile;


class AccountController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'age' => 'required|integer|min:0',
            'weight' => 'required|numeric|min:0',
            'gender' => 'required|in:male,female,other',
        ]);

        $user = Auth::user();

        // Create a profile if it doesn't exist
        $profile = $user->profile ?? Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'age' => $request->age,
                'weight' => $request->weight,
                'gender' => $request->gender
            ]
        );

        // If updateOrCreate was used, it already set the fields, so only save if $user->profile was used
        if ($user->profile) {
            $profile->age = $request->age;
            $profile->weight = $request->weight;
            $profile->gender = $request->gender;
            $profile->save();
        }

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }
}
