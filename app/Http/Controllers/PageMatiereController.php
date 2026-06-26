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
    // 1. On récupère tous les départements pour en extraire les filières
    $departements = \App\Models\Departement::all();
    $toutesLesFilieres = [];

    foreach ($departements as $dept) {
        if ($dept->filieres) {
            // On sépare le texte par les virgules
            $filieresTableau = explode(',', $dept->filieres);
            foreach ($filieresTableau as $filiere) {
                $filiereNettoyee = trim($filiere);
                // CORRECTION ICI : in_array avec un tiret du bas _
                if (!empty($filiereNettoyee) && !in_array($filiereNettoyee, $toutesLesFilieres)) {
                    $toutesLesFilieres[] = $filiereNettoyee; // Évite les doublons
                }
            }
        }
    }

    // On trie les filières par ordre alphabétique
    sort($toutesLesFilieres);

    return view('rabieta.gestion.creer_une_matiere', compact('toutesLesFilieres'));
  }


public function store(Request $donneesSaisies)
{
    // On crée le module/matière en y associant la filière choisie
    // Note : Assure-toi d'avoir une colonne 'filiere' ou 'niveau' dans ta table 'matieres' si tu veux la stocker dedans,
    // sinon Laravel l'enregistrera simplement avec le nom et le coefficient.
    \App\Models\Matiere::create([
        'nom_matiere' => $donneesSaisies->nom_matiere,
        'coefficient' => $donneesSaisies->coefficient,
        'filiere'     => $donneesSaisies->filiere_choisie,
         
    ]);

    return redirect('/matieres')->with('success', 'Module/Matière ajoutée avec succès à la filière !');
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
