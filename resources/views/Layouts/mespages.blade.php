<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon application de gestion d'école</title>
    
    <!-- Le lien Bootstrap pour la mise en forme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Lien pour les icônes Bootstrap -->
    <link rel="stylesheet" href="https://jsdelivr.net">
</head>

<body>
    
    <!-- Remise en place de la barre bleue de navigation -->
        <!-- Barre de navigation bleue -->
        <!-- Barre de navigation bleue -->
    <nav class="navbar navbar-expand-lg bg-primary mb-4">
        <div class="container py-2">
            @if(Auth::check() && Auth::user()->role == 'enseignant' && \App\Models\Departement::where('chef_id', Auth::id())->exists())
                <!-- 1. MENU DU CHEF DE DÉPARTEMENT -->
                <a class="nav-link d-inline mx-2 text-white" href="/dashboard">Tableau de bord</a>
                <a class="nav-link d-inline mx-2 text-white" href="/chef/filieres">Filières</a>
                <a class="nav-link d-inline mx-2 text-white" href="/chef/etudiants">Étudiants</a>
                <a class="nav-link d-inline mx-2 text-white" href="/chef/enseignants">Enseignants</a>
                <!-- Ce bouton mène bien vers la LISTE globale filtrée -->
                <a class="nav-link d-inline mx-2 text-white" href="/cours">Emploi du temps</a>
                <!-- Ce bouton (si tu veux le rajouter) mènerait vers la création -->
                <a class="nav-link d-inline mx-2 text-white fw-bold" href="/cours/creer"><i class="bi bi-plus-circle"></i> Créer</a>
            
            @elseif(Auth::check() && Auth::user()->role == 'admin')
                <!-- 2. MENU DE L'ADMINISTRATEUR -->
                <a class="nav-link d-inline mx-2 text-white" href="/dashboard">Dashboard Admin</a>
                <a class="nav-link d-inline mx-2 text-white" href="/matieres">Matières</a>
                <a class="nav-link d-inline mx-2 text-white" href="/notes">Notes</a>
                <a class="nav-link d-inline mx-2 text-white" href="/etudiants">Étudiants</a>
                <a class="nav-link d-inline mx-2 text-white" href="/enseignants">Enseignants</a>
                <!-- Ce bouton doit mener STRICTEMENT à /cours (la liste), pas /cours/creer -->
                <a class="nav-link d-inline mx-2 text-white fw-bold" href="/cours">Cours</a>
                <a class="nav-link d-inline mx-2 text-white" href="/departements">Départements</a>

            @else
                <!-- 3. MENU ÉTUDIANT -->
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
