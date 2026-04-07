<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Matiere;
use App\Models\User;

class cour extends Model
{
    use HasFactory;
    protected $fillable = ['titre', 'niveau', 'jour', 'horaire', 'matiere_id', 'user_id'];

public function enseignant()
{
    return $this->belongsTo(User::class, 'user_id');
}
public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }

public function contenus()
    {
        return $this->hasMany(Contenu::class, 'cour_id');
    }
}
