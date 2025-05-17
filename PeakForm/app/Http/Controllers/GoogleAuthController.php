<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountActivityMail;

class GoogleAuthController extends Controller
{
    public function redirect(){
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $google_account = Socialite::driver('google')->user();

        if (!empty($google_account)) {
            $fullName = explode(' ', $google_account->name, 2); // [Fname, Lname]

            // Check if an account with the same email exists but wasn't registered via Google
            $emailUser = User::where('email', $google_account->email)->first();

            if ($emailUser && !$emailUser->google_id) {
                return redirect()->route('login')->withErrors([
                    'email' => 'An account with this email already exists. Please log in using your email and password.'
                ]);
            }

            // Check if user already exists via Google
            $existingUser = User::where('google_id', $google_account->id)->first();

            // Create or update the user
            $user = User::updateOrCreate(
                ['google_id' => $google_account->id],
                [
                    'Fname' => $fullName[0] ?? '',
                    'Lname' => $fullName[1] ?? '',
                    'email' => $google_account->email,
                    'password' => Hash::make(Str::random(8)),
                ]
            );

            Auth::login($user);

            // Redirect based on whether user was newly created or already existed
            if ($existingUser) {
                return redirect()->route('overview_tab'); // Returning user
            } else {
                Mail::to($user->email)->send(new AccountActivityMail($user));
                return redirect()->route('welcome_page'); // New user
            }
        }

        // Optional: Redirect somewhere safe if Google data is missing
        return redirect()->route('login')->withErrors([
            'email' => 'Google login failed.'
        ]);
    }    
}
