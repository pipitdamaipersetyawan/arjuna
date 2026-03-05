<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GoogleController;

/*
|--------------------------------------------------------------------------
| ROOT → LANGSUNG CEK LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| GOOGLE LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/auth/google', [GoogleController::class, 'redirect'])
    ->name('google.redirect');

Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->name('google.callback');


/*
|--------------------------------------------------------------------------
| AREA YANG HARUS LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    /*
    | DASHBOARD
    */
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    /*
    | PROFILE
    */
    Route::view('/profile', 'profile.show')->name('profile.show');

    /*
    | UPDATE PROFILE
    */
    Route::put('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');

});