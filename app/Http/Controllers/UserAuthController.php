<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use \Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{

    //fonction pour afficher la liste des utilisateurs
    public function index(){
        $users = User::all();
        if(count($users) == 0){
            return response()->json([
                'message' => 'La liste des utilisateurs est vide'
            ]);
        }
        return response()->json( $users);
    }
    
   
    //fonction register
    public function register(Request $request){
        $registerUserData = $request->validate([
            'nom'=>'required|string',
            'prenom'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8'
        ]);
        $user = User::create([
            'nom' => $registerUserData['nom'],
            'prenom' => $registerUserData['prenom'],
            'email' => $registerUserData['email'],
            'password' => Hash::make($registerUserData['password']),
        ]);
        return response()->json($user);
    }

    //fonction de modification d'un utilisateur
    public function update(Request $request, User $user){
        $updateUserData = $request->validate([
            'nom'=>'string',
            'prenom'=>'string',
            'email'=>'string|email',
            'password'=>''
        ]);
        $user->update([
            'nom' => $updateUserData['nom'],
            'prenom' => $updateUserData['prenom'],
            'email' => $updateUserData['email'],
            'password' => Hash::make($updateUserData['password']),
        ]);
        return response()->json([
            'message' => 'User Updated',
        ]);
    }

    // fonction de suppression d'un utilisateur
    public function delete(User $user){
        $user->delete();
        return response()->json([
            'message' => 'User Deleted',
        ]);
    }

    
// Fonction de connexion login
public function login(Request $request){
    // Validation des données d'entrée
    $loginUserData = $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string|min:8', // Correction: ajout du type string et de la validation min:8
    ]);

    // Recherche de l'utilisateur par email
    $user = User::where('email', $loginUserData['email'])->first();

    // Vérification des identifiants
    if (!$user || !Hash::check($loginUserData['password'], $user->password)) {
        return response()->json([
            'message' => 'Identifiants incorrects'
        ], 401); // Retourne une erreur 401 en cas d'échec
    }

    // Création du token d'authentification pour l'utilisateur
    $token = $user->createToken($user->nom.'-AuthToken')->plainTextToken;

    // Récupération des rôles de l'utilisateur via la relation 'roles'
    $roles = $user->roles()->get();

    // Envoi de la réponse avec le token, les infos utilisateur et les rôles
    return response()->json([
        'access_token' => $token, 
        'user' => $user, 
        'roles' => $roles,
    ]);
}


    // fonction de connexion logout
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
            'message'=>'logged out'    
        ]);
        }

        //fonction pour connecter un utilisateur à un role
        public function attachRole(Request $request, User $user)
        {
            $user->roles()->attach($request->role);
            return response()->json([
                'message' => 'Role ajouter avec succès',
            ]);
        }
        //fonction pour deconnecter un utilisateur à un role
        public function detachRole(User $user, Role $role)
        {
            $user->roles()->detach($role);
            return response()->json([
                'message' => 'Role supprimé avec succès',
            ]);
        }

        //fonction pour recuperer tous les utilisateurs avec leurs roles
        public function getUsersWithRoles()
        {
            $users = User::with('roles')->get();
            return response()->json($users);
        }

        public function getConnectedUserRoles(){
            return response()->json(
                auth()->user()->roles()->get()
            );
        }

        //fonction pour ajouter et supprimer un tableau de plusieurs roles à un utilisateur
        public function attachDetachRoles(User $user, request $request){
            if ($request->has('roles')) {
                $roles = $request->input('roles');
                $user->roles()->sync($roles);
                return response()->json([
                    'message' => 'Rôles ajoutés ou supprimés avec succès',
                ]);
            }else {
                return response()->json([],400);
            }
        }
        // fonction pour recuperer les donnees de l'utilisateur connecté en  ayant son token
        public function getConnectedUser(){
            return response()->json(auth()->user());
        }
        
        
        
}
