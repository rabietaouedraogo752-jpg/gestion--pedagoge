<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', "Mon application de gestion d'école")</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container py-1">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 align-items-lg-center">
                    
                    @if(Auth::check() && Auth::user()->role == 'chef_departement')
                        <li class="nav-item"><a class="nav-link text-white" href="/dashboard"><i class="bi bi-speedometer2 me-1"></i> Tableau de bord</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/chef/filieres"><i class="bi bi-diagram-3 me-1"></i> Filières</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/chef/etudiants"><i class="bi bi-people me-1"></i> Étudiants</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/chef/enseignants"><i class="bi bi-person-badge me-1"></i> Enseignants</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/cours"><i class="bi bi-calendar3 me-1"></i> Emploi du temps</a></li>
                        <li class="nav-item"><a class="nav-link text-white fw-bold" href="/cours/creer"><i class="bi bi-plus-circle me-1"></i> Créer</a></li>
                    
                    @elseif(Auth::check() && Auth::user()->role == 'admin')
                        <li class="nav-item"><a class="nav-link text-white" href="/dashboard"><i class="bi bi-speedometer2 me-1"></i> Dashboard Admin</a></li>
                        <li class="nav-item">
                            <a class="nav-link text-white d-flex align-items-center" href="/admin/validation-comptes">
                                <i class="bi bi-shield-lock-fill me-1 text-warning"></i> Validation Comptes
                                <span class="badge bg-danger ms-2">{{ \App\Models\User::where('est_valide', 0)->count() }}</span>
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link text-white" href="/departements"><i class="bi bi-bank me-1"></i> Départements</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/enseignants"><i class="bi bi-person-badge me-1"></i> Enseignants</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/etudiants"><i class="bi bi-people me-1"></i> Étudiants</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/matieres"><i class="bi bi-journal-text me-1"></i> Modules</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="/notes"><i class="bi bi-pencil-square me-1"></i> Notes</a></li>
                        <li class="nav-item"><a class="nav-link text-white fw-bold" href="/cours"><i class="bi bi-calendar3 me-1"></i> Cours</a></li>

                    @else
                        <li class="nav-item"><a class="nav-link text-white" href="/dashboard"><i class="bi bi-speedometer2 me-1"></i> Mon Dashboard</a></li>
                    @endif

                </ul>

                @if(Auth::check())
                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-light btn-sm text-white px-3 me-2 my-1 my-lg-0" href="/profil">
                                <i class="bi bi-person-circle me-1"></i> Mon Profil
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm text-white px-3 w-100">
                                    <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                @endif
            </div>
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
    @stack('scripts')
</body>
</html>