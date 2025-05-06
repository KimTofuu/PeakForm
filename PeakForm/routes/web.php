<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\BodyMetricsController;
use App\Mail\MealReminder;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

Route::post('/register', [AuthController::class, 'register'])->name('register');

// Route::get('/', function () {
//     return view('index');
// });

Route::get('/login', function () {return view('login');});

Route::get('/register', function () {
    return view('register');
})->name('register.submit');

Route::get('/overview_tab', function () {
    $user = Auth::user();
    return view('overview_tab', compact('user'));
})->name('overview_tab')->middleware('auth:sanctum');

Route::get('/google-auth/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/google-auth/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');


Route::post('/chat', [ChatbotController::class, 'chat']);
Route::post('/generate-meal-plan', [MealController::class, 'generateMealPlan']);
Route::post('/workout-split', [WorkoutController::class, 'generateSplit']);
// Route::middleware('auth:sanctum')->post('/workout-split', [WorkoutController::class, 'generateSplit']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route::apiResource('posts', PostController::class);
// Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/mealRemind', function () {
    $users = User::all();

    foreach ($users as $user) {
        Mail::to($user->email)->send(new MealReminder($user));
    }
});

// Route::get('/google-auth/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
// Route::get('/google-auth/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

//TEST LANG
Route::get('/glogin', function () {
    return view('login');
});

Route::post('/body-metrics', [BodyMetricsController::class, 'store']);

Route::get('/', function () {
    return view('index');
})->name('index');

Route::get('/progress_tab', function () {
    $user = Auth::user();
    return view('progress_tab', compact('user'));
})->name('progress_tab');

Route::get('/workouts_tab', function () {
    $user = Auth::user();
    return view('workouts_tab', compact('user'));
})->name('workouts_tab');

Route::get('/welcome_page', function () {
    $user = Auth::user();
    return view('welcome_page', compact('user'));
})->name('welcome_page');

Route::get('/mealplan_tab', function () {
    $user = Auth::user();
    return view('mealplan_tab', compact('user'));
})->name('mealplan_tab');

Route::get('/profile_tab', function () {
    $user = Auth::user();
    return view('profile_tab', compact('user'));
})->name('profile_tab');

Route::get('/personal_info', function () {
    return view('personal_info');
})->name('personal_info');

Route::get('/workout_plan_1', function () {
    return view('workout_plan_1');
})->name('workout_plan_1');

Route::get('/workout_plan_2', function () {
    return view('workout_plan_2');
})->name('workout_plan_2');

Route::get('/workout_plan_3', function () {
    return view('workout_plan_3');
})->name('workout_plan_3');

Route::get('/workout_plan_4', function () {
    return view('workout_plan_4');
})->name('workout_plan_4');


Route::post('/workout_plan_1', [WorkoutController::class, 'storeGoal'])->name('workout_plan_1');
Route::post('/workout_plan_2', [WorkoutController::class, 'storeSetup'])->name('workout_plan_2');
Route::post('/workout_plan_3', [WorkoutController::class, 'storeIntensity'])->name('workout_plan_3');
Route::post('/workout_plan_4', [WorkoutController::class, 'storeDays'])->name('workout_plan_4');

