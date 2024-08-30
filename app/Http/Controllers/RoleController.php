<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class RoleController extends Controller
{
   
// Fonction pour afficher la liste des rôles
    public function index(){
        $roles = Role::all();
        return response()->json($roles);
    }

   
    public function create(Request $request)
    {
        
    }

    //fonction pour ajouter un role
        public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|unique:roles|max:255',
            'description' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $createdRole = Role::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return response()->json($createdRole);
    }

    public function show(Role $role)
    {
        //
    }
    
    
    public function edit(Request $request, Role $role)
    {
    
    }

    //fonction pour modifier un role
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|unique:roles|max:255',
            'description' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
    
        $role->update([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);
    
        return response()->json($role);
    }
    
    
    // Fonction pour supprimer un rôle
    public function destroy(Role $role)
    {
        $isDeleted = $role->delete();
        
        if(!$isDeleted){
            return response()->json(["message" => "Echec de suppression"], 400);
        }
        
        return response()->json([
            'message' => 'Rôle supprimé avec succès',
        ]);
    }

}


