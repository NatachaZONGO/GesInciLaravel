<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidents = Incident::all();
        return response()->json($incidents);
        if ( $request->user()) {
           dd('la liste des incidents');
        }
        if (count($incidents) == 0) {
            return response()->json([
                'message' => 'La liste des incidents est vide',
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
            'nom' => 'required|string|unique:incidents|max:255',
            'description' => 'string|max:255',
            'type_incident_id' => 'required|exists:type_incidents,id',
            'priorite' => 'in:faible,moderate,important',
            'service_id' => 'required|exists:services,id',
            'soumis_par' => 'required|exists:users,id',
            'date_soumission' => 'required|date',
            'prise_en_charge_par' => 'required|exists:users,id',
            'date_prise_en_charge' => 'required|date',
            'statut' => 'required|in:en_cours,traite,annule',
            'commentaires' => 'string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $incident = Incident::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'type_incident_id' => $request->type_incident_id,
            'priorite' => $request->priorite,
            'service_id' => $request->service_id,
            'soumis_par' => $request->soumis_par,
            'date_soumission' => $request->date_soumission,
            'prise_en_charge_par' => $request->prise_en_charge_par,
            'date_prise_en_charge' => $request->date_prise_en_charge,
            'statut' => $request->statut,
            'commentaires' => $request->commentaires,
        ]);
        return response()->json($incident);
    }

    /**
     * Display the specified resource.
     */
    public function show(Incident $incident)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incident $incident)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incident $incident)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'description' => 'string|max:255',
            'type_incident_id' => 'required|exists:type_incidents,id',
            'priorite' => 'required|in:faible,moderate,important',
            'service_id' => 'required|exists:services,id',
            'soumis_par' => 'required|exists:users,id',
            'date_soumission' => 'required|date',
            'prise_en_charge_par' => 'required|exists:users,id',
            'date_prise_en_charge' => 'required|date',
            'statut' => 'required|in:en_cours,traite,annule',
            'commentaires' => 'string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $incident->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'type_incident_id' => $request->type_incident_id,
            'priorite' => $request->priorite,
            'service_id' => $request->service_id,
            'soumis_par' => $request->soumis_par,
            'date_soumission' => $request->date_soumission,
            'prise_en_charge_par' => $request->prise_en_charge_par,
            'date_prise_en_charge' => $request->date_prise_en_charge,
            'statut' => $request->statut,
            'commentaires' => $request->commentaire,
        ]);
        return response()->json($incident);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incident $incident)
    {
        $incident->delete();
        if (!$incident) {
            return response()->json($incident);
        }
        return response()->json($incident);
    }
}
