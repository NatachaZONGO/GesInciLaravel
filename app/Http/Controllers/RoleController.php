<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class RoleController extends Controller
{
   
// Fonction pour afficher la liste des rôles
    public function index(request $request)
    {
       dd (auth()->user());

        $roles = Role::all();
        return response()->json($roles);
        if ( $request->user()) {
           dd('la liste des rôles');
        }
        if (count($roles) == 0) {
            return response()->json([
                'message' => 'La liste des rôles est vide',
            ]);
        }

        
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

        $role = Role::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return response()->json($role);
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
            'nom' => 'required|string|max:255',
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
        $role->delete();

        if (!$role) {
            return response()->json($role);
        }

        return response()->json($role);
    }

}


