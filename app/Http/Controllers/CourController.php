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
    $user = auth()->user();

    // 1. On prépare la requête de base
    $demande = \App\Models\Cour::with(['matiere', 'enseignant']);

        // SECTORISATION : Filtrage ultra-sécurisé contre les espaces invisibles
    if ($user->role == 'enseignant') {
        $chefDepartement = \App\Models\Departement::where('chef_id', $user->id)->first();
        
        if ($chefDepartement) {
            // Le array_map('trim', ...) élimine TOUS les espaces invisibles au début et à la fin des mots
            $filieres = array_map('trim', explode(',', $chefDepartement->filieres));
            
            $demande->whereIn('filiere', $filieres);
        } else {
            $demande->where('user_id', $user->id);
        }
    }


    // 3. Filtres de recherche optionnels
    if ($recherche) {
        $demande->where('filiere', 'LIKE', "%{$recherche}%");
    } 

    if ($niveauchoisi) {
        $demande->where('niveau', $niveauchoisi);
    }

    $les_cours = $demande->orderBy('jour', 'asc')->get();
    
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
        // ON SUPPRIME la ligne 'titre' et 'description' car elles n'existent pas en BDD
        'niveau'      => $donneesSaisies->niveau,
        'matiere_id'  => $donneesSaisies->matiere_id,
        'user_id'     => $donneesSaisies->user_id,
        'jour'        => $donneesSaisies->jour,
        'horaire'     => $donneesSaisies->horaire,
    ]);
    
    return redirect('/cours')->with('success', 'Cours ajouté à l\'emploi du temps !');
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
        'fichier_joint' =>$ajout,
    ]);
    return redirect('/test-enseignant')->with('success', 'Chapitre publié !');
}

public function afficherDétails($id)
{
    // je récupère le contenu associé à chaque cours
    $leCour = \App\Models\Cour::with('contenus')->findOrFail($id);
    
    return view('rabieta.etudiant.voir_contenu_cours', compact('leCour'));
}
public function supprimerUnCours($id)
{
    // 1. Récupération du cours en base de données
    $cour = \App\Models\Cour::find($id);

    if ($cour) {
        // 2. Suppression de la ligne de l'emploi du temps
        $cour->delete();
    }

    // 3. Retour automatique sur la page du planning avec un message vert de succès
    return redirect('/cours')->with('success', 'Le cours a été retiré de l\'emploi du temps avec succès !');
}


}

