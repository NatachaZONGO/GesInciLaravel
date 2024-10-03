<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class MesIncidentController extends Controller
{
   
    public function index(){

        // Utilisateur authentifié
        $user = auth()->user();
        $incidents = Incident::with(['type_incident', 'service', 'prise_en_charge_par'])
            ->where('soumis_par', $user->id) // Incidents soumis par l'utilisateur
            ->get();
        // Vérification si la liste des incidents est vide
        if ($incidents->isEmpty()) {
            return response()->json([
                'message' => 'La liste des incidents est vide',
            ]);
        }
        return response()->json($incidents);

    }

    public function show(Incident $incident){

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


















    

}