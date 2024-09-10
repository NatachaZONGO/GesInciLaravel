<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description'];

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

   
}
