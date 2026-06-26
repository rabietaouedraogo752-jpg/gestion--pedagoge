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
        if ($user->role == 'etudiant') {
            $mesNotes = \App\Models\Note::where('user_id', $user->id)->with('matiere')->get();
            $mesCours = \App\Models\Cour::where('filiere', $user->niveau)->with('matiere')->get();
                        
            $toutesMatieres = \App\Models\Matiere::all();
            $annonces = \App\Models\Annonce::where('cible_niveau', $user->niveau)
                ->orWhereNull('cible_niveau')
                ->orderBy('created_at', 'desc')
                ->get();

            return view('rabieta.etudiant.accueil', compact('mesNotes', 'mesCours', 'toutesMatieres', 'annonces'));
        }

        // 2. SI C'EST UN ENSEIGNANT
        if ($user->role == 'enseignant') {
            $chefDepartement = \App\Models\Departement::where('chef_id', $user->id)->first();

            // CAS A : ENSEIGNANT CHEF DE DÉPARTEMENT
            if ($chefDepartement) {
                $filieres = array_map('trim', explode(',', $chefDepartement->filieres)); 

                $totalFilieres = count($filieres);
                $totalEtudiantsDept = \App\Models\User::where('role', 'etudiant')->whereIn('niveau', $filieres)->count();
                $coursIds = \App\Models\Cour::whereIn('niveau', $filieres)->pluck('user_id')->unique();
                $totalEnseignantsDept = \App\Models\User::whereIn('id', $coursIds)->count();
                $totalCoursDept = \App\Models\Cour::whereIn('niveau', $filieres)->count();

                // On récupère toutes les annonces de la base pour le flux de gestion du chef
                $annonces = \App\Models\Annonce::orderBy('created_at', 'desc')->get();

                return view('rabieta.chef.accueil', compact(
                    'chefDepartement', 'filieres', 'totalFilieres', 
                    'totalEtudiantsDept', 'totalEnseignantsDept', 'totalCoursDept', 'annonces'
                ));
            }

            // CAS B : ENSEIGNANT CLASSIQUE / SIMPLE
            $mesCours = \App\Models\Cour::where('user_id', $user->id)->with('matiere')->get();
            $annonces = \App\Models\Annonce::orderBy('created_at', 'desc')->take(10)->get();
            
            // 🚨 RECTIFICATION : On ajoute 'annonces' à l'intérieur de la fonction compact() !
            return view('rabieta.enseignant.accueil', compact('mesCours', 'annonces'));
        }

        // Sécurité par défaut
        return redirect('/');
    }
}
