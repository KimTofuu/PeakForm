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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);
    
        // Manually hash the password
        $fields['password'] = Hash::make($fields['password']);
    
        $user = User::create($fields);
        
        // Send email
        Mail::to($user->email)->send(new AccountActivityMail($user));

        $token = $user->createToken($request->Fname);

        Auth::login($user);

        return redirect()->route('welcome_page'); // Redirect to the dashboard after registration
        
        // return response()->json([
        //     'user' => $user,
        //     'token' => $token->plainTextToken
        // ]);
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
            return redirect()->intended('overview_tab'); // or wherever you want to redirect the user
        }

        // If authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return redirect()->route('index')->with('message', 'Logged out successfully.');
    }
    
    // public function logout(Request $request)
    // {
    //     Auth::logout(); 

    //     $request->session()->invalidate(); 
    //     $request->session()->regenerateToken(); 

    //     return redirect('/index');
    // }
}
 