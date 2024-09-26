<?php

namespace App\Http\Controllers;

use App\Models\Statistique;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class StatistiqueController extends Controller
{
    ///////////////////////////////////Nombre d'incident resolu par agent/////////////////////////////////////////
    public function incidentsParAgent($agent_id){
        // Récupérer le nombre d'incidents résolus par l'agent spécifique
        $incidents = DB::table('incidents')
            ->select('id', 'nom', 'description', 'statut', 'date_soumission', 'date_prise_en_charge')
            ->where('statut', 'traite')
            ->where('prise_en_charge_par', $agent_id) 
            ->get();
    
         // Compter le nombre d'incidents résolus
        $totalIncidents = $incidents->count();

        // Retourner les incidents et le total
        return response()->json([
            'total_resolus' => $totalIncidents,
            'incidents' => $incidents
        ]);

    }    


    ///////////////////////////////////////Nombre d'incident par service/////////////////////////////////////////

    public function incidentsParService($serviceId) {
        // Récupérer le nombre total d'incidents pour le service spécifié
        $totalIncidents = DB::table('incidents')
            ->where('service_id', $serviceId)
            ->count();
    
        // Récupérer les détails des incidents pour le service spécifié
        $incidents = DB::table('incidents')
            ->where('service_id', $serviceId)
            ->get();
    
        // Préparer la réponse
        $response = [
            'service_id' => $serviceId,
            'total_incidents' => $totalIncidents,
        ];
    
        return response()->json($response);
    }
    

    //////////////////////////////////////////Duree moyenne de resolution des incidents/////////////////////////////////////
    public function dureeMoyenneResolution($incident)
        {
            $incidentData = DB::table('incidents')->where('id', $incident)->first();

            if (!$incidentData || $incidentData->statut !== 'traite') {
                return response()->json(['message' => 'Incident non trouvé ou non traité'], 404);
            }

            // Calculer la durée de résolution
            $duree = DB::table('incidents')
                ->select(DB::raw('TIMESTAMPDIFF(SECOND, date_soumission, date_prise_en_charge) as duree_en_secondes'))
                ->where('id', $incident)
                ->first();

            // Conversion en jours, heures, minutes et secondes
            $totalSecondes = $duree->duree_en_secondes;
            $jours = floor($totalSecondes / 86400);
            $heures = floor(($totalSecondes % 86400) / 3600);
            $minutes = floor(($totalSecondes % 3600) / 60);
            $secondes = $totalSecondes % 60;

            return response()->json([
                'Duree_de_resolution' => [
                    'jours' => $jours,
                    'heures' => $heures,
                    'minutes' => $minutes,
                    'secondes' => $secondes
                ],
            ]);
    }



    /////////////////////////////////////////duree moyenne entre la soumission et le debut de la prise en charge///////////////////////
    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Statistique $statistique)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statistique $statistique)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Statistique $statistique)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Statistique $statistique)
    {
        //
    }
}
