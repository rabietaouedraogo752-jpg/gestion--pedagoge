<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenu extends Model
{
    use HasFactory;
    protected $fillable = ['cour_id', 'titre_du_chapitre', 'contenu_du_cours', 'fichier_joint'];

public function cour() {
    return $this->belongsTo(Cour::class);
}

}
