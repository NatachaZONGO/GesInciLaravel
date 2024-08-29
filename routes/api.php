<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\RoleController;
use App\Models\User;
use App\Models\Role;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Routes
Route::get('users', [UserAuthController::class, 'index'])->middleware('auth:sanctum');
Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login']);
Route::delete('logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');
//Route de attachRole
Route::post('attachRoles/{user}', [UserAuthController::class, 'attachRole']);
//Route de detachRole
Route::delete('/detachRoles/{user}', [UserAuthController::class, 'detachRole']);
//Route de recuperation des utilisateurs avec leurs roles
Route::get('/getUsersWithRoles', [UserAuthController::class, 'getUsersWithRoles']);


// Route de recuperation des roles
Route::resource('roles', RoleController::class);




