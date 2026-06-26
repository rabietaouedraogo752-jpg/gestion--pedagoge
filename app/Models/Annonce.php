<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    
    protected $fillable = ['departement_id', 'titre', 'contenu', 'cible_niveau'];
public function departement()
    {
        return $this->belongsTo(Departement::class, 'departement_id');
    }
}
