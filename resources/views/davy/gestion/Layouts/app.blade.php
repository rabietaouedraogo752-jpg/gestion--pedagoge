<!DOCTYPE html>
<html lang="fr">
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gestion École')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; }
        .card { border: none; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
        .avatar-circle { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; }
    </style>
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
<body>

@auth
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            <i class="bi bi-mortarboard-fill me-2"></i>GestionÉcole
        </a>
        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="text-white">
                <i class="bi bi-person-circle me-1"></i>
                {{ Auth::user()->nom_complet }}
                <span class="badge bg-light text-dark ms-1">{{ ucfirst(Auth::user()->role) }}</span>
            </span>
            <a href="{{ route('profil.show') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-person"></i> Mon profil
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </button>
            </form>
        </div>
    </div>
</nav>
@endauth

<div class="container mt-3">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info alert-dismissible fade show">
            <i class="bi bi-info-circle me-2"></i>{{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
</div>

<div class="container mt-3">
    @yield('content')
</div>

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
@stack('scripts')
</body>
</html>