<?php

use Illuminate\Support\Facades\Route;

Route::resource('/users', '\Ocelot\Core\Http\Controllers\UsersController')->middleware(['web', 'auth']);
