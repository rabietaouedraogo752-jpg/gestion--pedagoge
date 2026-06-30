<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $user->est_valide == 0) {
        return redirect('/inscription/en-attente');
    }
        $data = [];

        // Données communes à tous les rôles
        $data['totalEtudiants']    = User::where('role', 'etudiant')->count();
        $data['totalEnseignants']  = User::where('role', 'enseignant')->count();
        $data['totalAdmins']       = User::where('role', 'admin')->count();
        $data['totalUtilisateurs'] = User::count();

        // -------------------------------------------------------------
        // LOGIQUE COMMUNE POUR L'ADMIN (STATISTIQUES DE DAVY)
        // -------------------------------------------------------------
        if ($user->role == 'admin') {
            // Inscriptions par mois
            $inscriptionsParMois = User::select(
                    DB::raw('MONTH(created_at) as mois'),
                    DB::raw('YEAR(created_at) as annee'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereYear('created_at', date('Y'))
                ->groupBy('annee', 'mois')
                ->orderBy('mois')
                ->get();

            $nomsMois = [
                1=>'Jan', 2=>'Fév', 3=>'Mar', 4=>'Avr',
                5=>'Mai', 6=>'Jun', 7=>'Jul', 8=>'Aoû',
                9=>'Sep', 10=>'Oct', 11=>'Nov', 12=>'Déc'
            ];

            $data['moisLabels'] = [];
            $data['moisData']   = [];
            foreach ($inscriptionsParMois as $item) {
                $data['moisLabels'][] = $nomsMois[$item->mois] . ' ' . $item->annee;
                $data['moisData'][]   = $item->total;
            }

            // Répartition par rôle avec pourcentages
            $total = $data['totalUtilisateurs'] > 0 ? $data['totalUtilisateurs'] : 1;
            $data['rolesData']         = [
                $data['totalEtudiants'],
                $data['totalEnseignants'],
                $data['totalAdmins'],
            ];
            $data['rolesPourcentages'] = [
                round(($data['totalEtudiants']   / $total) * 100, 1),
                round(($data['totalEnseignants'] / $total) * 100, 1),
                round(($data['totalAdmins']      / $total) * 100, 1),
            ];

            // Derniers inscrits
            $data['derniersInscrits'] = User::orderBy('created_at', 'desc')->take(5)->get();

            // 🚨 SÉCURITÉ ADMIN : On ajoute les annonces pour alimenter son espace_informations
            $data['annonces'] = \App\Models\Annonce::orderBy('created_at', 'desc')->get();

            // On renvoie la vue Admin de Davy avec TOUTES les données ($data)
            return view('davy.gestion.dashboard', $data);
        }

        // -------------------------------------------------------------
        // AIGUILLAGE PAR RÔLES (TES MODULES - RABIETA)
        // -------------------------------------------------------------

        // 1. SI C'EST UN ÉTUDIANT
        // 1. SI C'EST UN ÉTUDIANT
        if ($user->role == 'etudiant') {
            $mesNotes = \App\Models\Note::where('user_id', $user->id)->with('matiere')->get();
            $mesCours = \App\Models\Cour::where(function($q) use ($user) {
                            // Il cherche si la filière du cours est "Informatique" (sa spécialité)
                            $q->where('filiere', $user->specialite)
                              ->orWhere('filiere', $user->filiere);
                        })
                        ->where('niveau', $user->niveau) // Et il valide que c'est bien pour la "Licence 1"
                        ->with('matiere')
                        ->get();
                        
            $toutesMatieres = \App\Models\Matiere::all();
            
            // ✅ CORRECTION ICI : On prend le niveau de l'étudiant, le vide ET le mot clé "Global"
            $annonces = \App\Models\Annonce::where('cible_niveau', $user->niveau)
                ->orWhere('cible_niveau', 'Global')
                ->orWhereNull('cible_niveau')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('rabieta.etudiant.accueil', compact('mesNotes', 'mesCours', 'toutesMatieres', 'annonces'));
        }

        // 2. SI C'EST UN ENSEIGNANT
                // -------------------------------------------------------------
        // 2. SI C'EST UN CHEF DE DÉPARTEMENT (NOUVEAU RÔLE ISOLÉ)
        // -------------------------------------------------------------
        if ($user->role == 'chef_departement') {
            $chefDepartement = \App\Models\Departement::where('chef_id', $user->id)->first();
            $filieres = $chefDepartement ? array_map('trim', explode(',', $chefDepartement->filieres)) : []; 

            $totalFilieres = count($filieres);
                    // 2. Nombre d'étudiants inscrits dans les filières du département
        $totalEtudiantsDept = \App\Models\User::where('role', 'etudiant')
            ->where(function($q) use ($filieres) {
                $q->whereIn('filiere', $filieres)
                  ->orWhereIn('specialite', $filieres); // Sécurité pour chercher dans 'specialite' (ex: Informatique)
            })
            ->count();
            // Avant : $coursIds = \App\Models\Cour::whereIn('niveau', $filieres)->pluck('user_id')->unique();
// Après (Correction) : 

$coursIds = \App\Models\Cour::whereIn('filiere', $filieres)->pluck('user_id')->unique();
$totalEnseignantsDept = \App\Models\User::whereIn('id', $coursIds)->where('role', 'enseignant')->count();
 $totalCoursDept = \App\Models\Cour::whereIn('niveau', $filieres)->count();

            $annonces = \App\Models\Annonce::orderBy('created_at', 'desc')->get();

            return view('rabieta.chef.accueil', compact(
                'chefDepartement', 'filieres', 'totalFilieres', 
                'totalEtudiantsDept', 'totalEnseignantsDept', 'totalCoursDept', 'annonces'
            ));
        }

        // -------------------------------------------------------------
        // 3. SI C'EST UN ENSEIGNANT CLASSIQUE / SIMPLE
        // -------------------------------------------------------------
        if ($user->role == 'enseignant') {
            $mesCours = \App\Models\Cour::where('user_id', $user->id)->with('matiere')->get();
            $annonces = \App\Models\Annonce::orderBy('created_at', 'desc')->take(10)->get();
            
            return view('rabieta.enseignant.accueil', compact('mesCours', 'annonces'));
        }

        // Sécurité par défaut
        return redirect('/');
    }
    // 1. AFFICHER LA LISTE DES COMPTES EN ATTENTE
public function listeAttente()
{
    // On récupère uniquement les utilisateurs dont le compte est bloqué (est_valide = 0)
    $utilisateursEnAttente = \App\Models\User::where('est_valide', 0)->orderBy('created_at', 'desc')->get();
    
    return view('davy.gestion.validation_comptes', compact('utilisateursEnAttente'));
}

// 2. VALIDER LE COMPTE D'UN UTILISATEUR
public function validerLeCompte($id)
{
    // 1. On récupère l'utilisateur ciblé
    $user = \App\Models\User::findOrFail($id);
    
    // 2. Affectation forcée de la valeur
    $user->est_valide = 1;
    
    // 3. Sauvegarde immédiate en base de données
    $user->save();

    return redirect('/admin/validation-comptes')->with('success', 'Le compte de ' . $user->prenom . ' ' . $user->nom . ' a été validé avec succès !');
}


}
