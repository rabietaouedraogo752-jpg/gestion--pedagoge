<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    use HasFactory;

    protected $fillable = ['nom_departement', 'filieres', 'chef_id'];

    // Relation pour récupérer l'enseignant qui est chef
    public function chef()
    {
        return $this->belongsTo(User::class, 'chef_id');
    }
}

