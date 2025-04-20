<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountActivityMail;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function register(Request $request) {
        $fields = $request->validate([
            'Fname' => 'required|max:255',
            'Lname' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);
    
        // Manually hash the password
        $fields['password'] = Hash::make($fields['password']);
    
        $user = User::create($fields);
        
        // Send email
        Mail::to($user->email)->send(new AccountActivityMail($user));

        $token = $user->createToken($request->Fname);
    
        return response()->json([
            'user' => $user,
            'token' => $token->plainTextToken
        ]);        
    }
    
    public function showLoginForm() {
        return view('login'); // This will return the login form.
    }

    public function login(Request $request) {
        // Validate input
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Check if credentials are correct
        if (Auth::attempt($credentials)) {
            // Authentication was successful
            return redirect()->intended('dashboard_1'); // or wherever you want to redirect the user
        }

        // If authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out.'
        ];
    }
}
 