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
use App\Http\Controllers\MesIncidentController;
use App\Http\Controllers\StatistiqueController;
use App\Models\Departement;
use App\Models\Service;
use App\Models\TypeIncident;
use App\Models\Incident;


Route::get('/user', function (Request $request) {
    return $request->user();
});

//Routes
Route::get('users', [UserAuthController::class, 'index'])->middleware('auth.token');;
Route::post('register', [UserAuthController::class, 'register']);
Route::delete('deleteUser/{user}', [UserAuthController::class, 'delete'])->middleware('auth.token');;
Route::put('updateUser/{user}', [UserAuthController::class, 'update'])->middleware('auth.token');;
Route::post('login', [UserAuthController::class, 'login']);
Route::delete('logout', [UserAuthController::class, 'logout'])->middleware('auth.token');;
//Route de attachRole
Route::post('attachRoles/{user}', [UserAuthController::class, 'attachRole']);
//Route de detachRole
Route::delete('/detachRoles/{user}', [UserAuthController::class, 'detachRole']);
Route::post('/attachDetachRoles/{user}', [UserAuthController::class, 'attachDetachRoles']);
//Route de recuperation des utilisateurs avec leurs roles
Route::get('/getUsersWithRoles', [UserAuthController::class, 'getUsersWithRoles']);
//Route pour avoir les roles d un utilisateur
Route::get('/getConnectedUserRoles', [UserAuthController::class, 'getConnectedUserRoles'])->middleware('auth.token');
//Route pour afficher tous les agents
Route::get('/getConnectedUser', [UserAuthController::class, 'getConnectedUser'])->middleware('auth.token');
//Route pour afficher toutes les informations de l'utilisateur connecte
Route::get('/getConnectedUserInfos', [UserAuthController::class, 'getConnectedUserInfos'])->middleware('auth.token');


// Route pour les roles
Route::resource('roles', RoleController::class)->middleware('auth.token')->middleware('auth.token');;
Route::get('roleByName/{name}', [RoleController::class, 'getRoleByName'])->middleware('auth.token');
//Route pour afficher les utilisateurs d'un role
Route::get('/roles_/getUsersByRole/{role}', [RoleController::class, 'getUsersByRole']);
//Routes pour les departements
Route::resource('departements', DepartementController::class)->middleware('auth.token');;
Route::get('departements_/getDepartementsWithServices', [DepartementController::class, 'getDepartementsWithServices']);
//Route pour les services
Route::resource('services', ServiceController::class)->middleware('auth.token');;
//Route pour les types d'incidents
Route::resource('typeIncidents', TypeIncidentController::class)->middleware('auth.token');;
//Route pour les incidents
Route::resource('incidents', IncidentController::class)->middleware('auth.token');
//Route pour l'affectation d'un incident a un agent
Route::put('incidents_/{incident}/affectInciUser/{user}', [IncidentController::class, 'affectInciUser'])->middleware('auth.token');;
//Route pour l'ajout du commentaire d'un incident
Route::put('incidents_/addComment/{incident}', [IncidentController::class, 'addComment'])->middleware('auth.token');;
//Route pour la modification de la priorite
Route::put('/incidents/priorite/{incident}', [IncidentController::class, 'updatePriorite'])->middleware('auth.token');;
//Route pour la modification du statut
Route::put('/incidents/statut/{incident}', [IncidentController::class, 'updateStatut']);
//Route pour afficher la liste des incidents q'un utilisateur a soumis
Route::get('/incidents_/getIncidentsByUser/{user}', [IncidentController::class, 'getIncidentsByUser']);
//Route pour afficher la liste des incidents q'un utilisateur a pris en charge
Route::get('/incidents_/getIncidentsByUserCharge/{user}', [IncidentController::class, 'getIncidentsByUserCharge']);
//Route pour afficher la liste des incidents qui ont ete affectés a un agent
Route::get('/incidents_/getIncidentsByUserAffect/{user}', [IncidentController::class, 'getIncidentsByUserAffect']);


Route::get('/mesincidents', [MesIncidentController::class, 'index'])->middleware('auth.token');
Route::get('mesincidents/{incident}', [IncidentController::class, 'show'])->middleware('auth.token');


/////////////////////////////////////////Statistiques Routes/////////////////////////////////////////////////
Route::get('/statistiques/incidents-par-agent', [StatistiqueController::class, 'incidentsParAgent']);
Route::get('/statistiques/incidents-par-service', [StatistiqueController::class, 'incidentsParService']);
Route::get('/statistiques/duree-moyenne-resolution', [StatistiqueController::class, 'dureeMoyenneResolution']);
Route::get('/statistiques/incidents-par-agent/{agent_id}', [StatistiqueController::class, 'incidentsParAgent']);
Route::get('/statistiques/incidents-par-service/{serviceId}', [StatistiqueController::class, 'incidentsParService']);
Route::get('/statistiques/duree-resolution/{incident}', [StatistiqueController::class, 'dureeMoyenneResolution']);
