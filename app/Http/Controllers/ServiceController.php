<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les services avec leur département associé
        $services = Service::with('departement')->get();
        
        if (count($services) == 0) {
            return response()->json([
                'message' => 'La liste des services est vide',
            ]);
        }

        return response()->json($services);
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
            'nom' => 'required|string|unique:services|max:255',
            'description' => 'string|max:255',
            'departement_id' => 'required|integer' // Validation de la clé étrangère
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Création du service avec le département lié
        $service = Service::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'departement_id' => $request->departement_id
        ]);

        return response()->json($service, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return response()->json($service->load('departement')); // Charger aussi le département associé
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'string|max:255',
            'departement_id' => 'required|exists:departements,id' // Validation de la clé étrangère
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Mise à jour du service avec le département lié
        $service->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'departement_id' => $request->departement_id
        ]);

        return response()->json($service);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return response()->json(null, 204); // Retourner 204 pour signifier une suppression réussie
    }
}
