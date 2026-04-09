<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    // cette ligne liste les colonnes que l'on peut modifier dans la base de donnée
    protected $fillable = ['user_id', 'matiere_id', 'valeur_note'];
    //ce bloc permet de dire qu'une note appartient à un étudiant
public function user()
     {
    return $this->belongsTo(\App\Models\User::class);
}
//une note est relié à une matière
public function matiere() {
    return $this->belongsTo(\App\Models\Matiere::class, 'matiere_id');
}


}
