<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EtudiantEnseignantController extends Controller
{
  // ETUDIANTS
     public function indexEtudiants(Request $mottape)
  {

    $recherche = $mottape->get('search');

    

    
    $niveau = $mottape->get('niveau');
    // JE PARS de tous les étudiants puis je filtre
    $demande = \App\Models\User::where('role', 'etudiant');
    if ($recherche) {
        $demande->where(function($query) use ($recherche) {
            $query->where('nom',    'LIKE', "%{$recherche}%")
                  ->orWhere('prenom', 'LIKE', "%{$recherche}%");
        });
    
    } 
    if ($niveau) {
      $demande->where('niveau', $niveau);
    }
        $etudiants = $demande->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();
    
    return view('rabieta.gestion.liste_des_etudiants', compact('etudiants'));
    
  }
  public function createEtudiant()
  {
    return view('rabieta.gestion.creer_etudiant');
  }
  public function storeEtudiant(Request $donneesSaisies)
  {
    \App\Models\User::create([
        'nom' => $donneesSaisies->nom,
        'prenom' => $donneesSaisies->prenom,
        'email' => $donneesSaisies->email,
        // ici le mot de passe sera remplacé par une autre autre cryptée avec bcrypt
        'password'=>bcrypt($donneesSaisies->password),
        'role'=> 'etudiant',
        'telephone' =>'telephone',
        'niveau' =>'niveau',
        'adresse' =>'adresse',
         'date_naissance' => \Carbon\Carbon::parse($donneesSaisies->date_naissance)->format('Y-m-d'),
    ]);
    return redirect('/etudiants')->with('success', 'étudiant(e) ajouté(e) !');
  }
  public function editEtudiant($id)
  {
    //la fonction findOrFail permet de chercher l'id précis de l'étudiant 
    $etudiant= \App\Models\User::findOrFail($id);
    
    return view('rabieta.gestion.modifier_etudiant', compact('etudiant'));
  }
  public function updateEtudiant(Request $donneesSaisies, $id)
  {
    $etudiant = \App\Models\User::findOrFail($id);
    $etudiant->update([
        'nom' => $donneesSaisies->nom,
        'prenom' => $donneesSaisies->prenom,
        'email' => $donneesSaisies->email,
        'telephone' =>$donneesSaisies->telephone,
        'niveau' =>$donneesSaisies->niveau,
        'adresse' =>$donneesSaisies->adresse,
        'date_naissance' =>$donneesSaisies->date_naissance,
    ]);
    return redirect('/etudiants')->with('success', 'étudiant(e) mis(e) à jour!');
  }
  public function destroyEtudiant($id)
  {
    $etudiant = \App\Models\User::findOrFail($id);
    $etudiant->delete();

    return redirect('/etudiants')->with('success', 'étudiant(e) supprimé(e)!');
  }
  
  public function indexEnseignants(Request $mottape)
  {
    $recherche = $mottape->get('search');
    $enseigne= \App\Models\User::where('role', 'enseignant');
    if ($recherche) {
        $enseigne->where('nom', 'LIKE', "%{$recherche}%")->get();
    } 
        $enseignants = $enseigne->orderBy('nom', 'asc')->orderBy('prenom', 'asc')->get();
    
    return view('rabieta.gestion.liste_des_enseignants', compact('enseignants'));
    
  }
  public function createEnseignants()
  {
    return view('rabieta.gestion.creer_enseignant');
  }
  public function storeEnseignant(Request $donneesSaisies)
  {
    \App\Models\User::create([
        'nom' => $donneesSaisies->nom,
        'prenom' => $donneesSaisies->prenom,
        'email' => $donneesSaisies->email,
        'password'=>bcrypt($donneesSaisies->password),
        'role'=> 'enseignant',
        'specialite'=>$donneesSaisies->specialite,
        'telephone' => $donneesSaisies->telephone,
        'adresse' => $donneesSaisies->adresse,
        'date_naissance' => $donneesSaisies->date_naissance,


    ]);
    return redirect('/enseignants')->with('success', 'enseignant(e) ajouté(e) !');
  }
  public function editEnseignant($id)
  {
    $enseignant= \App\Models\User::findOrFail($id);
    
    return view('rabieta.gestion.modifier_enseignant', compact('enseignant'));
  }
  public function updateEnseignant(Request $donneesSaisies, $id)
  {
    $enseignant= \App\Models\User::findOrFail($id);
    $enseignant->update([
        'nom' => $donneesSaisies->nom,
        'prenom' => $donneesSaisies->prenom,
        'email' => $donneesSaisies->email,
        'role'=> 'enseignant',
        'specialite'=>$donneesSaisies->specialite,
        'telephone' => $donneesSaisies->telephone,
        'adresse' => $donneesSaisies->adresse,
        'date_naissance' => $donneesSaisies->date_naissance,
    ]);
    return redirect('/enseignants')->with('success', 'enseignant(e) mise à jour!');
  }
  public function destroyEnseignant($id)
  {
    $enseignant= \App\Models\User::findOrFail($id);
    $enseignant->delete();

    return redirect('/enseignants')->with('success', 'enseignant(e) supprimé(e)!');
  }
}
