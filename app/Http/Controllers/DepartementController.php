<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departement;
use App\Models\User;

class DepartementController extends Controller
{
    public function index()
    {
        // On récupère tous les départements avec leur chef
        $departements = Departement::with('chef')->get();
        return view('rabieta.gestion.liste_des_departements', compact('departements'));
    }

    public function create()
    {
        // On récupère uniquement les utilisateurs qui sont enseignants pour la liste déroulante
        $enseignants = User::where('role', 'enseignant')->get();
        return view('rabieta.gestion.creer_departement', compact('enseignants'));
    }

    public function store(Request $request)
    {
        Departement::create([
            'nom_departement' => $request->nom_departement,
            'filieres'        => $request->filieres,
            'chef_id'         => $request->chef_id,
        ]);

        return redirect('/departements')->with('success', 'Département créé avec succès !');
    }
    public function storeAnnonce(Request $request)
{
    $user = auth()->user();
    $departementId = null;

    // 1. Si c'est un enseignant-chef, on récupère son vrai pôle
    if ($user->role == 'enseignant') {
        $departement = \App\Models\Departement::where('chef_id', $user->id)->first();
        if ($departement) {
            $departementId = $departement->id;
        }
    }

    // 🚨 SÉCURITÉ DE SECOURS : Si l'ID est toujours vide (Enseignant simple ou Admin sans pôle)
    if (empty($departementId)) {
        $premierDept = \App\Models\Departement::first();
        // On récupère l'ID du premier département existant, sinon on met 1 par défaut
        $departementId = $premierDept ? $premierDept->id : 1;
    }

    // 2. Sauvegarde de l'annonce dans la base de données
    \App\Models\Annonce::create([
        'departement_id' => $departementId, // Ne sera plus jamais NULL !
        'titre'          => $request->titre,
        'contenu'        => $request->contenu,
        'cible_niveau'   => $request->cible_niveau, 
    ]);

    return back()->with('success', 'Information diffusée avec succès !');
}


public function listeFilieres()
{
    $chefDepartement = Departement::where('chef_id', auth()->id())->firstOrFail();
    $filieres = array_map('trim', explode(',', $chefDepartement->filieres));
    return view('rabieta.chef.filieres', compact('chefDepartement', 'filieres'));
}

public function listeEtudiants()
{
    $chefDepartement = Departement::where('chef_id', auth()->id())->firstOrFail();
    $filieres = array_map('trim', explode(',', $chefDepartement->filieres));

    // Récupère les étudiants groupés par leur filière (champ niveau)
    $etudiants = \App\Models\User::where('role', 'etudiant')
        ->whereIn('niveau', $filieres)
        ->orderBy('niveau')
        ->orderBy('nom')
        ->get();

    return view('rabieta.chef.etudiants', compact('chefDepartement', 'etudiants'));
}

public function listeEnseignants()
{
    $chefDepartement = Departement::where('chef_id', auth()->id())->firstOrFail();
    $filieres = array_map('trim', explode(',', $chefDepartement->filieres));

    // Trouve les IDs des enseignants affectés aux cours de ces filières
    $enseignantsIds = \App\Models\Cour::whereIn('niveau', $filieres)->pluck('user_id')->unique();
    $enseignants = \App\Models\User::whereIn('id', $enseignantsIds)->orderBy('nom')->get();

    return view('rabieta.chef.enseignants', compact('chefDepartement', 'enseignants'));
}
public function adminInformations()
{
    // 1. On récupère l'historique de toutes les annonces
    $annonces = \App\Models\Annonce::orderBy('created_at', 'desc')->get();

    // 2. On extrait la liste des filières pour la liste déroulante des cibles
    $departements = Departement::all();
    $toutesLesFilieres = [];
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

    return view('rabieta.gestion.espace_informations', compact('annonces', 'toutesLesFilieres'));
}
public function storeAnnonceAdmin(Request $request)
{
    // L'admin n'a pas de département attitré, on prend le premier département 
    // de la base pour éviter de laisser le champ vide en BDD
    $premierDept = Departement::first();

    \App\Models\Annonce::create([
        'departement_id' => $premierDept ? $premierDept->id : 1,
        'titre'          => $request->titre,
        'contenu'        => $request->contenu,
        'cible_niveau'   => $request->cible_niveau, // Contiendra Global, Enseignants ou la Filière choisie
    ]);

    return back()->with('success', 'Information diffusée avec succès par l\'administration !');
}

}
