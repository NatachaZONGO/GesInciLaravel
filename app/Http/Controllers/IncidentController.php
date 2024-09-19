<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incidents = Incident::with(['type_incident', 'service', 'soumis_par', 'prise_en_charge_par'])->get();
        if ($incidents->isEmpty()) {
            return response()->json([
                'message' => 'La liste des incidents est vide',
            ]);
        }
    
        return response()->json($incidents);
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
            'nom' => 'required|string|max:255',
            'description' => 'string|max:255',
            'type_incident_id' => 'required|exists:type_incidents,id',
            'service_id' => 'required|exists:services,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $incident = Incident::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'type_incident_id' => $request->type_incident_id,
            'priorite' => Incident::$MOYENNE,
            'service_id' => $request->service_id,
            'soumis_par' => auth()->user()->id,
            'date_soumission' => date('Y-m-d'),
            'prise_en_charge_par' => null,
            'date_prise_en_charge' => null,
            'statut' => Incident::$EN_COURS,
            'commentaire' => null,
        ]);
        return response()->json($incident);
    }

    /**
     * Display the specified resource.
     */
    //recuperation des informations d'un incident specifique
    public function show(Incident $incident)
{
    // Charger les relations
    $incident->load(
        'type_incident',
        'service',
        'soumis_par',
        'prise_en_charge_par'
    );

    // Retournertous les attributs et relations
    return response()->json([
        'nom' => $incident->nom,
        'description' => $incident->description,
        'priorite' => $incident->priorite,
        'statut' => $incident->statut,
        'type_incident' => $incident->type_incident,
        'service' => $incident->service,
        'soumis_par' => $incident->soumis_par,
        'date_soumission' => $incident->date_soumission,
        'prise_en_charge_par' => $incident->prise_en_charge_par,
        'date_prise_en_charge' => $incident->date_prise_en_charge,
        'commentaires' => $incident->commentaires,
    ]);
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
            'nom' => 'string|max:255',
            'description' => 'string|max:255',
            'type_incident_id' => 'exists:type_incidents,id',
            'priorite' => 'in:faible,moyenne,forte',
            'service_id' => 'exists:services,id',
            'soumis_par' => 'exists:users,id',
            'date_soumission' => 'date',
            'prise_en_charge_par' => 'exists:users,id',
            'date_prise_en_charge' => 'date',
            'statut' => 'in:en_cours,traite,annule',
            'commentaires' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $incident->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'type_incident_id' => $request->type_incident_id,
            //'priorite' => $request->priorite,
            'service_id' => $request->service_id,
            //'soumis_par' => $request->soumis_par,
            //'date_soumission' => $request->date_soumission,
            //'prise_en_charge_par' => $request->prise_en_charge_par,
            //'date_prise_en_charge' => $request->date_prise_en_charge,
            //'statut' => $request->statut,
            //'commentaires' => $request->commentaires,
        ]);
        return response()->json($incident);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Incident $incident)
    {
        $incident->delete();
        return response()->json(['message' => 'Incident supprimé avec succès']);
    }

    // Fonction pour affecter la gestion d un incident a un utilisateur
        public function affectInciUser($incidentId, $userId)
    {
        // Récupérer l'incident
    $incident = Incident::find($incidentId);
    if (!$incident) {
        return response()->json(['message' => 'Incident non trouvé'], 404);
    }

    // Récupérer l'utilisateur
    $user = User::find($userId);
    if (!$user) {
        return response()->json(['message' => 'Utilisateur non trouvé'], 404);
    }

    // Affecter l'incident à l'utilisateur (champ 'prise_en_charge_par')
    $incident->prise_en_charge_par = $user->id;
    $incident->save();

    return response()->json(['message' => 'Incident affecté avec succès à l\'utilisateur'], 200);
    }
    
   // fonction pour enregistrer le commentaire d'un incident dans le champ 'commentaires' de la table 'incidents'
    public function addComment($incidentId, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'commentaires' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $incident = Incident::find($incidentId);
        if (!$incident) {
            return response()->json(['message' => 'Incident non trouve'], 404);
        }
        $incident->commentaires = $request->commentaires;
        $incident->save();
        return response()->json($incident);
    }

    public function updatePriorite(Request $request, $id)
    {
        // Valider la demande pour s'assurer que 'priorite' est fourni et est valide
        $request->validate([
            'priorite' => 'required|string|max:255',
        ]);
    
        // Trouver l'incident par son ID
        $incident = Incident::findOrFail($id);
    
        // Mettre à jour uniquement le champ 'priorite'
        $incident->priorite = $request->input('priorite');
        $incident->save();
    
        // Retourner une réponse de succès
        return response()->json([
            'message' => 'Priorité mise à jour avec succès.',
            'incident' => $incident
        ]);
    }
    
    public function updateStatut(Request $request, $id)
    {
        // Valider la demande pour s'assurer que 'statut' est fourni et est valide
        $request->validate([
            'statut' => 'required|string|max:255',
        ]);
    
        // Trouver l'incident par son ID
        $incident = Incident::findOrFail($id);
    
        // Mettre à jour uniquement le champ 'statut'
        $incident->statut = $request->input('statut');
        $incident->save();
    
        // Retourner une réponse de succès avec l'objet incident mis à jour
        return response()->json([
            'message' => 'Statut mis à jour avec succès.',
            'incident' => $incident
        ], 200);
    }
      

}