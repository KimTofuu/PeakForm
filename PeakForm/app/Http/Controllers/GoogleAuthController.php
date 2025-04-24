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

    public function callback(){
        $google_account = Socialite::driver('google')->user();


        if (!empty($google_account)) {
            $fullName = explode(' ', $google_account->name, 2); // splits into [Fname, Lname]

            $user = User::updateOrCreate([
                'google_id' => $google_account->id
            ], [
                'Fname' => $fullName[0] ?? '',
                'Lname' => $fullName[1] ?? '',
                'email' => $google_account->email,
                'password' => Hash::make(Str::random(8)),
            ]);

            Auth::login($user);

            // dd(Auth::user());
            Mail::to($user->email)->send(new AccountActivityMail($user));

            return redirect()->route('register');
        }
    }
}
