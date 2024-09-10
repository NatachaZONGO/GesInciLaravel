<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'type_incident_id', 'commentaires', 'description', 'priorite', 'service_id', 'soumis_par', 'date_soumission', 'prise_en_charge_par', 'date_prise_en_charge', 'statut' ];

    public function type_incident()
    {
        return $this->belongsTo(TypeIncident::class, 'type_incident');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service');
    }
}
