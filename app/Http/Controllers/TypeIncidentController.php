<?php

namespace App\Http\Controllers;

use App\Models\TypeIncident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeIncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        {
     
             $typeIncidents = TypeIncident::all();
             return response()->json($typeIncidents);
             if ( $request->user()) {
                dd('les types d\'incidents');
             }
             if (count($typeIncidents) == 0) {
                 return response()->json([
                     'message' => 'La liste est vide',
                 ]);
             }
     
             
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
            'nom' => 'required|string|unique:type_incidents|max:255',
            'description' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            
            return response()->json($validator->errors(), 400);
        }

        $typeIncident = TypeIncident::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        return response()->json($typeIncident);
    }

    /**
     * Display the specified resource.
     */
    public function show(TypeIncident $typeIncident)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TypeIncident $typeIncident)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TypeIncident $typeIncident)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            
            return response()->json($validator->errors(), 400);
        }
    
        $typeIncident->update([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);
    
        return response()->json($typeIncident);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TypeIncident $typeIncident)
    {
        $typeIncident->delete();

        if (!$typeIncident) {
            return response()->json($typeIncident);
        }

        return response()->json($typeIncident);
    }
}
