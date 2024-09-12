<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departements = Departement::all();
        return response()->json($departements);
        if ( $request->user()) {
           dd('la liste des departements');
        }
        if (count($departements) == 0) {
            return response()->json([
                'message' => 'La liste des departements est vide',
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|unique:departements|max:255',
            'description' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            
            return response()->json($validator->errors(), 400);
        }

        $departement = Departement::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return response()->json($departement);;
    }

    /**
     * Display the specified resource.
     */
    public function show(Departement $departement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Departement $departement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departement $departement)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            
            return response()->json($validator->errors(), 400);
        }
    
        $departement->update([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);
    
        return response()->json($departement);
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departement $departement)
    {
        $departement->delete();

        if (!$departement) {
            return response()->json($departement);
        }

        return response()->json($departement);
    
    }

    //fonction pour afficher la liste des departements et les services liees
    public function getDepartementsWithServices(){
        $departements = Departement::with('services')->get();
        if(count($departements) == 0){
            return response()->json([
                'message' => 'La liste des departements est vide'
            ]);
        }
        return response()->json($departements);
    }
}
