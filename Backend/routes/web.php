<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\GoogleAuthController;

Route::get('/google-auth/redirect', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
Route::get('/google-auth/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

