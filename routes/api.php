<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\ServiceController;
use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\TypeIncidentController;
use App\Http\Controllers\IncidentController;
use App\Models\Departement;
use App\Models\Service;
use App\Models\TypeIncident;
use App\Models\Incident;


Route::get('/user', function (Request $request) {
    return $request->user();
});

//Routes
Route::get('users', [UserAuthController::class, 'index']);
Route::post('register', [UserAuthController::class, 'register']);
Route::delete('deleteUser/{user}', [UserAuthController::class, 'delete']);
Route::put('updateUser/{user}', [UserAuthController::class, 'update']);
Route::post('login', [UserAuthController::class, 'login']);
Route::delete('logout', [UserAuthController::class, 'logout']);
//Route de attachRole
Route::post('attachRoles/{user}', [UserAuthController::class, 'attachRole']);
//Route de detachRole
Route::delete('/detachRoles/{user}', [UserAuthController::class, 'detachRole']);
Route::post('/attachDetachRoles/{user}', [UserAuthController::class, 'attachDetachRoles']);
//Route de recuperation des utilisateurs avec leurs roles
Route::get('/getUsersWithRoles', [UserAuthController::class, 'getUsersWithRoles']);


// Route pour les roles
Route::resource('roles', RoleController::class);
//Routes pour les departements
Route::resource('departements', DepartementController::class);
//Route pour les services
Route::resource('services', ServiceController::class);
//Route pour les types d'incidents
Route::resource('typeIncidents', TypeIncidentController::class);
//Route pour les incidents
Route::resource('incidents', IncidentController::class);

