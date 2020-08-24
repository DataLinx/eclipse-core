<?php

use Illuminate\Support\Facades\Route;

Route::get('/home', '\Ocelot\Core\Http\Controllers\HomeController@index')->name('home');
Route::resource('/users', '\Ocelot\Core\Http\Controllers\UsersController')->middleware(['web', 'auth']);

/*
 * Auth routes, copied from laravel/ui AuthRouteMethods
 */
Route::get('login', '\Ocelot\Core\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
Route::post('login', '\Ocelot\Core\Http\Controllers\Auth\LoginController@login');

Route::post('logout', '\Ocelot\Core\Http\Controllers\Auth\LoginController@logout')->name('logout');

Route::get('register', '\Ocelot\Core\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', '\Ocelot\Core\Http\Controllers\Auth\RegisterController@register');

Route::get('password/reset', '\Ocelot\Core\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', '\Ocelot\Core\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', '\Ocelot\Core\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', '\Ocelot\Core\Http\Controllers\Auth\ResetPasswordController@reset')->name('password.update');

Route::get('password/confirm', '\Ocelot\Core\Http\Controllers\Auth\ConfirmPasswordController@showConfirmForm')->name('password.confirm');
Route::post('password/confirm', '\Ocelot\Core\Http\Controllers\Auth\ConfirmPasswordController@confirm');

Route::get('email/verify', '\Ocelot\Core\Http\Controllers\Auth\VerificationController@show')->name('verification.notice');
Route::get('email/verify/{id}/{hash}', '\Ocelot\Core\Http\Controllers\Auth\VerificationController@verify')->name('verification.verify');
Route::post('email/resend', '\Ocelot\Core\Http\Controllers\Auth\VerificationController@resend')->name('verification.resend');
