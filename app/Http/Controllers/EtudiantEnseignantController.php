<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EtudiantEnseignantController extends Controller
{
  // Partie étudiants
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
    // 1. On récupère tous les départements
    $departements = \App\Models\Departement::all();
    $toutesLesFilieres = [];

    // 2. On extrait proprement les filières sans doublons
    foreach ($departements as $dept) {
        if ($dept->filieres) {
            $filieresTableau = explode(',', $dept->filieres);
            foreach ($filieresTableau as $filiere) {
                $filiereNettoyee = trim($filiere);
                if (!empty($filiereNettoyee) && !in_array($filiereNettoyee, $toutesLesFilieres)) {
                    $toutesLesFilieres[] = $filiereNettoyee;
                }
            }
        }
    }
    sort($toutesLesFilieres);

    return view('rabieta.gestion.creer_etudiant', compact('departements', 'toutesLesFilieres'));
}

public function storeEtudiant(Request $donneesSaisies)
{
    \App\Models\User::create([
        'nom'            => $donneesSaisies->nom,
        'prenom'         => $donneesSaisies->prenom,
        'email'          => $donneesSaisies->email,
        'password'       => bcrypt($donneesSaisies->password),
        'role'           => 'etudiant',
        'telephone'      => $donneesSaisies->telephone,
        'adresse'        => $donneesSaisies->adresse,
        'filiere'        => $donneesSaisies->filiere_choisie, // La spécialité (ex: Génie Logiciel)
        'niveau'         => $donneesSaisies->niveau,          // L'année d'étude (ex: Licence 2)
        'departement_id' => $donneesSaisies->departement_id,
        'date_naissance' => \Carbon\Carbon::parse($donneesSaisies->date_naissance)->format('Y-m-d'),
    ]);

    return redirect('/etudiants')->with('success', 'Étudiant(e) inscrit(e) avec succès !');
}

  public function editEtudiant($id)
{
    $etudiant = \App\Models\User::findOrFail($id);

    // 1. On récupère les départements pour la liste déroulante
    $departements = \App\Models\Departement::all();
    $toutesLesFilieres = [];

    // 2. On extrait proprement les filières textuelles sans doublons
    foreach ($departements as $dept) {
        if ($dept->filieres) {
            $filieresTableau = explode(',', $dept->filieres);
            foreach ($filieresTableau as $filiere) {
                $filiereNettoyee = trim($filiere);
                if (!empty($filiereNettoyee) && !in_array($filiereNettoyee, $toutesLesFilieres)) {
                    $toutesLesFilieres[] = $filiereNettoyee;
                }
            }
        }
    }
    sort($toutesLesFilieres);

    return view('rabieta.gestion.modifier_etudiant', compact('etudiant', 'departements', 'toutesLesFilieres'));
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
        'adresse' => $donneesSaisies->adresse,
        'filiere' => $donneesSaisies->filiere_choisie, 
        'niveau'  => $donneesSaisies->niveau,          
        'departement_id' => $donneesSaisies->departement_id,       
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
  
  //Partie enseignant
  
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
