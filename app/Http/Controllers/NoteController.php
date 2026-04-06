<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $mot)
    {
      //je récupère le mot tapé à la barre
        $motrecherche = $mot->get('search');
        $niveau = $mot->get('niveau');
        //ici je prépare la requête
        $bulletin = \App\Models\User::where('role', 'etudiant')->with('notes.matiere');
        //pour rechercher une personne, on filtre par son nom
        if($motrecherche){
          $bulletin->where('nom', 'LIKE', "%{$motrecherche}%");
        }
        if ($niveau) {
           $bulletin->where('niveau', $niveau);
        }

        $etudiants= $bulletin->orderBy('nom','asc')->get();
        $matieres = \App\Models\Matiere::all();
        
        return view('rabieta.gestion.liste_des_notes', compact('etudiants', 'matieres'));
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
}