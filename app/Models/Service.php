<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['nom', 'description','departement_id'];

    //la relation "appartient à un département"
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }

    }
