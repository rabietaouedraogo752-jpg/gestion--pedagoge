<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon application de gestion d'école</title>
    
    <!-- Le lien Bootstrap pour la mise en forme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- CORRECTION ICI : Lien complet et fonctionnel pour charger les icônes Bootstrap -->
    <link rel="stylesheet" href="https://jsdelivr.net">
</head>

<body>
    
    <!-- Remise en place de la barre bleue de navigation -->
    <nav class="navbar navbar-expand-lg bg-primary mb-4">
        <div class="container py-2">
            <!-- 🚨 MODIFICATION ICI : On cible directement le nouveau rôle chef_departement -->
            @if(Auth::check() && Auth::user()->role == 'chef_departement')
                <!-- 1. MENU DU CHEF DE DÉPARTEMENT -->
                <a class="nav-link d-inline mx-2 text-white" href="/dashboard"><i class="bi bi-speedometer2 me-1"></i> Tableau de bord</a>
                <a class="nav-link d-inline mx-2 text-white" href="/chef/filieres"><i class="bi bi-diagram-3 me-1"></i> Filières</a>
                <a class="nav-link d-inline mx-2 text-white" href="/chef/etudiants"><i class="bi bi-people me-1"></i> Étudiants</a>
                <a class="nav-link d-inline mx-2 text-white" href="/chef/enseignants"><i class="bi bi-person-badge me-1"></i> Enseignants</a>
                <a class="nav-link d-inline mx-2 text-white" href="/cours"><i class="bi bi-calendar3 me-1"></i> Emploi du temps</a>
                <a class="nav-link d-inline mx-2 text-white fw-bold" href="/cours/creer"><i class="bi bi-plus-circle me-1"></i> Créer</a>
            
            @elseif(Auth::check() && Auth::user()->role == 'admin')
                <!-- 2. MENU DE L'ADMINISTRATEUR -->
                <a class="nav-link d-inline mx-2 text-white" href="/dashboard">Dashboard Admin</a>
                <li class="nav-item">
    <a class="nav-link {{ request()->is('admin/validation-comptes') ? 'active text-primary fw-bold' : 'text-dark' }}" href="/admin/validation-comptes"><i class="bi bi-shield-lock-fill me-2 text-danger"></i> Validation Comptes
        <!-- Badge dynamique rouge optionnel qui indique le nombre de comptes bloqués -->
        <span class="badge bg-danger float-end ms-2">{{ \App\Models\User::where('est_valide', 0)->count() }}</span>
    </a>
</li>

                 <a class="nav-link d-inline mx-2 text-white" href="/departements">Départements</a>
                 <a class="nav-link d-inline mx-2 text-white" href="/enseignants">Enseignants</a>
                 <a class="nav-link d-inline mx-2 text-white" href="/etudiants">Étudiants</a>
                <a class="nav-link d-inline mx-2 text-white" href="/matieres">Modules</a>
                <a class="nav-link d-inline mx-2 text-white" href="/notes">Notes</a>
                
                
                <a class="nav-link d-inline mx-2 text-white fw-bold" href="/cours">Cours</a>
               

            @else
                <!-- 3. MENU ÉTUDIANT OU ENSEIGNANT SIMPLE -->
                <a class="nav-link d-inline mx-2 text-white" href="/dashboard">Mon Dashboard</a>
               
            @endif
        </div>
    </nav>

    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
