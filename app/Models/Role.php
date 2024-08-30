<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description'];

    //Relation entre Role et User
    public function users():belongsToMany
    {
        return $this->belongsToMany(User::class);
    }

     
    
}
