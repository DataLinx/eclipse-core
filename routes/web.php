<?php

use Eclipse\Core\Http\Controllers\DashboardController;
use Eclipse\Core\Http\Controllers\TestController;
use Eclipse\Core\Http\Controllers\UsersController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

// Redirect root requests
// -------------------------------------------
Route::get('/', function () {
    if (! auth()->check()) {
        return redirect('dashboard');
    } else {
        return redirect('login');
    }
});

// Routes for logged in users only
// -------------------------------------------
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::resource('users', UsersController::class);

    // Testing route — available only in development
    if (App::environment('local')) {
        Route::get('test/components', [TestController::class, 'components']);
    }
});

// Glide image server
// TODO Check if it's possible to load this route without the web middleware
// -------------------------------------------
Route::get('img/{path}', function ($path) {
    return app()->glide->getImageResponse($path, request()->all());
})->where('path', '.*');
