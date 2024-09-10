<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [UserAuthController::class, 'login'])->name('login');