<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $mot)
{
    // 1. On récupère les filtres (attention au nom du paramètre dans l'URL !)
    $motrecherche = $mot->get('search');
    $niveau = $mot->get('niveau');
    
    // On synchronise : l'URL envoie ?filiere=MPCI
    $filiereChoisie = $mot->get('filiere'); 

    // 2. Extraction globale de toutes les filières existantes pour la barre d'onglets
    $departements = \App\Models\Departement::all();
    $toutesLesFilieres = [];
    foreach ($departements as $dept) {
        if ($dept->filieres) {
            $tableFiliere = explode(',', $dept->filieres);
            foreach ($tableFiliere as $f) {
                $nettoye = trim($f);
                if (!empty($nettoye) && !in_array($nettoye, $toutesLesFilieres)) {
                    $toutesLesFilieres[] = $nettoye;
                }
            }
        }
    }
    sort($toutesLesFilieres);

    // 3. Préparation de la requête des étudiants avec filtrage par spécialité
    $bulletin = \App\Models\User::where('role', 'etudiant')->with('notes.matiere');
    
    if ($motrecherche) {
        $bulletin->where('nom', 'LIKE', "%{$motrecherche}%");
    }
    if ($niveau) {
        $bulletin->where('niveau', $niveau);
    }
    
    // Filtrage des étudiants selon la filière cliquée
    if ($filiereChoisie) {
        $bulletin->where(function($q) use ($filiereChoisie) {
            $q->where('filiere', $filiereChoisie)
              ->orWhere('specialite', $filiereChoisie)
              ->orWhere('niveau', $filiereChoisie);
        });
    }

    $etudiants = $bulletin->orderBy('nom', 'asc')->get();

    // 4. CLOISONNEMENT STRICT DES MATIÈRES DANS LES COLONNES
    if ($filiereChoisie) {
        // Si l'utilisateur clique sur MPCI, on ne prend QUE la matière qui a 'MPCI' dans sa colonne filiere
        $matieres = \App\Models\Matiere::where('filiere', $filiereChoisie)
                    ->orderBy('nom_matiere', 'asc')
                    ->get();
    } else {
        // Si aucun onglet n'est cliqué (Toutes les filières), on affiche tout
        $matieres = \App\Models\Matiere::orderBy('nom_matiere', 'asc')->get();
    }
    
    return view('rabieta.gestion.liste_des_notes', compact('etudiants', 'matieres', 'toutesLesFilieres'));
}


    public function create($user_id, $matiere_id)
    {
        $etudiant = \App\Models\User::findOrFail($user_id);
        $matiere = \App\Models\Matiere::findOrFail($matiere_id);
        return view('rabieta.gestion.creer_une_note', compact('user_id', 'matiere_id','etudiant', 'matiere'));
    }
    public function store(Request $donneesSaisies)
    {
    \App\Models\Note::create([
        'user_id' => $donneesSaisies->user_id,
        'matiere_id' => $donneesSaisies->matiere_id,
        'valeur_note' =>$donneesSaisies->valeur_note,
    ]);
    return redirect('/notes')->with('success', 'Note ajoutée !');
  }
  public function destroy($id)
  {
    $note= \App\Models\Note::findOrFail($id);
    $note->delete();

    return redirect('/notes')->with('success', 'Note supprimée!');
  }
  public function edit($id)
  {
    $note= \App\Models\Note::findOrFail($id);
    
    return view('rabieta.gestion.modifier_note', compact('note'));
  }
  public function update(Request $donneesSaisies, $id)
  {
    $note = \App\Models\Note::findOrFail($id);
    $note->update([
         'valeur_note' =>$donneesSaisies->valeur_note,
    ]);
    return redirect('/notes')->with('success', 'Matiere mise à jour!');
  }
  public function indexEnseignant($id)
{
    $cours = \App\Models\cour::with('matiere')->findOrFail($id);

    // l'enseignant ne peut pas accéder au cours d'un autre
    if ($cours->user_id !== auth()->id()) {
        abort(403);
    }

    $etudiants = \App\Models\User::where('role', 'etudiant')
        ->where('niveau', $cours->niveau)
        ->with(['notes' => function($q) use ($cours) {
            $q->where('matiere_id', $cours->matiere_id);
        }])
        ->orderBy('nom')
        ->get();

    return view('rabieta.enseignant.enseignant_saisi', compact('cours', 'etudiants'));
}

public function sauvegarderNotes(\Illuminate\Http\Request $req, $id)
{
    $cours = \App\Models\cour::findOrFail($id);

    if ($cours->user_id !== auth()->id()) {
        abort(403);
    }

    foreach ($req->notes as $etudiantId => $valeur) {
        if ($valeur === null || $valeur === '') continue;

        \App\Models\Note::updateOrCreate(
            ['user_id' => $etudiantId, 'matiere_id' => $cours->matiere_id],
            ['valeur_note' => $valeur]
        );
    }

    return back()->with('success', 'Notes enregistrées !');
}
}