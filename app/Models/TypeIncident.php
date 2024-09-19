<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeIncident extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'description',
    ];

    public function incidents()
    {
        return $this->hasMany(Incident::class ,'type_incident_id');
    }
}
