<?php

use App\Http\Controllers\UserOverviewController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', UserOverviewController::class)->name('users.index');
