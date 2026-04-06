<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageMatiereController extends Controller
{
  public function index(Request $mottape)
  {
    $recherche = $mottape->get('search');
    if ($recherche) {
        $toutesMatieres= \App\Models\Matiere::where('nom_matiere', 'LIKE', "%{$recherche}%")->get();
    } else {
        $toutesMatieres = \App\Models\Matiere::all();
    }
    return view('rabieta.gestion.liste_des_matieres', compact('toutesMatieres'));
    
  }
  public function create()
  {
    return view('rabieta.gestion.creer_une_matiere');
  }
  public function store(Request $donneesSaisies)
  {
    \App\Models\Matiere::create([
        'nom_matiere' => $donneesSaisies->nom_matiere,
        'coefficient' => $donneesSaisies->coefficient,
    ]);
    return redirect('/matieres')->with('success', 'Matiere ajoutée !');
  }
  public function edit($id)
  {
    $laMatiere= \App\Models\Matiere::findOrFail($id);
    
    return view('rabieta.gestion.modifier_matiere', compact('laMatiere'));
  }
  public function update(Request $donneesSaisies, $id)
  {
    $laMatiere = \App\Models\Matiere::findOrFail($id);
    $laMatiere->update([
        'nom_matiere' => $donneesSaisies->nom_matiere,
        'coefficient' => $donneesSaisies->coefficient,
    ]);
    return redirect('/matieres')->with('success', 'Matiere mise à jour!');
  }
  public function destroy($id)
  {
    $laMatiere = \App\Models\Matiere::findOrFail($id);
    $laMatiere->delete();

    return redirect('/matieres')->with('success', 'Matiere supprimée!');
  }
}
