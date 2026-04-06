<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        // Données uniquement pour l'admin
        if ($user->isAdmin()) {

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
        }

        return view('davy.gestion.dashboard', $data);
    }
}