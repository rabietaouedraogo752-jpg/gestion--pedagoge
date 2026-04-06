<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cour;
use App\models\Contenu;

class CourController extends Controller
{
    // 
    
    public function index(Request $mottape)
{
    $recherche = $mottape->get('search');
    $niveauchoisi = $mottape->get('niveau');

    // 1. On PRÉPARE la requête (SANS le ->get() pour l'instant)
    $demande= \App\Models\Cour::with(['matiere', 'enseignant']);

    // 2. On ajoute les conditions SI elles existent
    if ($recherche) {
        // Attention : dans ta table 'cours', c'est sûrement 'titre' et non 'nom'
        $demande->where('titre', 'LIKE', "%{$recherche}%");
    } 

    if ($niveauchoisi) {
        $demande->where('niveau', $niveauchoisi);
    }

    // 3. On exécute ENFIN la requête avec ->get()
    $les_cours = $demande->orderBy('titre', 'asc')->get();
    
    return view('rabieta.gestion.liste_des_cours', compact('les_cours'));
}

  public function create()
    {
        $enseignants = \App\Models\User::where('role', 'enseignant')->get();
        $toutesMatieres = \App\Models\Matiere::all();
        return view('rabieta.gestion.creer_cour', compact('enseignants', 'toutesMatieres'));
    }
    public function store(Request $donneesSaisies)
  {
    \App\Models\cour::create([
        'titre'       => $donneesSaisies->titre,
        'niveau'      => $donneesSaisies->niveau,
        'matiere_id'  => $donneesSaisies->matiere_id,
        'user_id'     => $donneesSaisies->user_id,
        'description' => $donneesSaisies->description,
        'jour'     => $donneesSaisies->jour,
        'horaire' => $donneesSaisies->horaire,
    ]);
    return redirect('/cours')->with('success', 'cours ajoutée !');
  }
  public function edit($id)
  {
    $leCour= \App\Models\cour::findOrFail($id);
    $enseignants = \App\Models\User::where('role', 'enseignant')->get();
    $toutesMatieres = \App\Models\Matiere::all();
    
    return view('rabieta.gestion.modifier_cour', compact('leCour', 'enseignants', 'toutesMatieres'));
  }
  public function update(Request $donneesSaisies, $id)
  {
    $leCour = \App\Models\Cour::findOrFail($id);
    $leCour->update([
        'titre'       => $donneesSaisies->titre,
        'niveau'      => $donneesSaisies->niveau,
        'matiere_id'  => $donneesSaisies->matiere_id,
        'user_id'     => $donneesSaisies->user_id,
        'jour'        => $donneesSaisies->jour,
        'horaire'     => $donneesSaisies->horaire, 
    ]);
    return redirect('/cours')->with('success', 'cours mise à jour!');
  }
  public function destroy($id)
  {
    $leCour = \App\Models\cour::findOrFail($id);
    $leCour->delete();

    return redirect('/cours')->with('success', 'Cours  supprimé!');
  }
  // 1. Affiche le formulaire (Côté Enseignant)
public function ajouterContenu($id) {
    $leCour = \App\Models\Cour::findOrFail($id);
    return view('rabieta.enseignant.pour_ajout_contenu', compact('leCour'));
}
public function creerContenu($id)
{
    // 1. On cherche le cours concerné
    $leCour = \App\Models\Cour::findOrFail($id);
    
    // 2. On appelle ta vue avec son nom exact
    return view('rabieta.enseignant.pour_ajout_contenu', compact('leCour'));
}


// 2. Enregistre le chapitre
public function sauvegarderContenu(Request $demande) {
  $ajout = null;
  if ($demande->hasFile('fichier_joint')) {
        // je  donne un nom unique au fichier pour éviter les doublons
        $ajout = time().'.'.$demande->fichier_joint->extension();  
        // je le déplace dans le dossier public/uploads/cours
        $demande->fichier_joint->move(public_path('uploads/cours'), $ajout);
    }

    \App\Models\Contenu::create([
        'cour_id' => $demande->cour_id,
        'titre_du_chapitre' => $demande->titre_du_chapitre,
        'contenu_du_cours' => $demande->contenu_du_cours,
        'fichier_joint' => $demande->$ajout,
    ]);
    return redirect('/test-enseignant')->with('success', 'Chapitre publié !');
}

}
