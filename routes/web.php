<?php

use Illuminate\Support\Facades\Route;
use Ocelot\Core\Http\Controllers\DashboardController;
use Ocelot\Core\Http\Controllers\UsersController;

// Redirect root requests
Route::get('/', function () {
    if ( ! auth()->check()) {
        return redirect('dashboard');
    } else {
        return redirect('login');
    }
});

// Routes for logged in users only
// -------------------------------------------
Route::middleware('auth')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/users', UsersController::class);
});

// Glide image server
// TODO Check if it's possible to load this route without the web middleware
// -------------------------------------------
Route::get('img/{path}', function ($path) {
    return app()->glide->getImageResponse($path, request()->all());
})->where('path', '.*');
