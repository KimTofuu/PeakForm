<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountActivityMail;


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
    

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required'
        ]);

        //FOR WEB APP NA AUTHENTICATION
        // Auth::attempt(['email' => $email, 'password' => $password]);

        //FOR API
        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            return [
                'message' => 'The provided credentials are incorrect.'
            ];
        }

        $token = $user->createToken($user->Fname);

        return [
            'user' => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return [
            'message' => 'You are logged out.'
        ];
    }
}
 