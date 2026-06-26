@extends('Layouts.mespages')
@section('content')

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="card p-4 bg-primary text-white border-0 shadow-sm mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <span class="badge bg-light text-primary mb-2 fw-bold">Direction Pédagogique</span>
                <h2 class="fw-bold">Tableau de Bord : {{ $chefDepartement->nom_departement }}</h2>
                <p class="mb-0 text-white-50">Statistiques globales et outils de gestion de votre pôle.</p>
            </div>
            <i class="bi bi-speedometer2 text-white-50" style="font-size: 3rem;"></i>
        </div>
    </div>

    <!-- CARTES DES STATISTIQUES -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card p-3 border-0 bg-white shadow-sm text-center">
                <i class="bi bi-diagram-3 text-warning mb-2" style="font-size: 2rem;"></i>
                <h3 class="fw-bold mb-0">{{ $totalFilieres }}</h3>
                <small class="text-muted fw-bold">Filières gérées</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 border-0 bg-white shadow-sm text-center">
                <i class="bi bi-people text-success mb-2" style="font-size: 2rem;"></i>
                <h3 class="fw-bold mb-0">{{ $totalEtudiantsDept }}</h3>
                <small class="text-muted fw-bold">Étudiants inscrits</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 border-0 bg-white shadow-sm text-center">
                <i class="bi bi-person-badge text-info mb-2" style="font-size: 2rem;"></i>
                <h3 class="fw-bold mb-0">{{ $totalEnseignantsDept }}</h3>
                <small class="text-muted fw-bold">Corps Enseignant</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card p-3 border-0 bg-white shadow-sm text-center">
                <i class="bi bi-calendar-check text-danger mb-2" style="font-size: 2rem;"></i>
                <h3 class="fw-bold mb-0">{{ $totalCoursDept }}</h3>
                <small class="text-muted fw-bold">Séances Planifiées</small>
            </div>
        </div>
    </div>

    <!-- ANNONCES ET ACTIONS -->
    <div class="row g-4">
        <div class="col-lg-7">
            <!-- Formulaire de Publication d'Annonces -->
            <div class="card p-4 border-0 bg-white shadow-sm mb-4">
                <h5 class="fw-bold text-danger mb-3"><i class="bi bi-megaphone me-2"></i>Diffuser une annonce aux filières</h5>
                <form action="/chef/annonces/envoyer" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Titre de l'annonce</label>
                        <input type="text" name="titre" class="form-control" placeholder="ex: Avis de démarrage des examens" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Filière concernée</label>
                        <select name="cible_niveau" class="form-select">
                            <option value="">Toutes les filières</option>
                            @foreach($filieres as $f)
                                <option value="{{ $f }}">{{ $f }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Message</label>
                        <textarea name="contenu" class="form-control" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger w-100 fw-bold">Publier le communiqué</button>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <!-- Historique des annonces -->
            <div class="card p-4 border-0 bg-white shadow-sm">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-history me-2"></i>Flux de diffusion</h5>
                @forelse($dernieresAnnonces as $annonce)
                    <div class="border-bottom pb-2 mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold text-dark small">{{ $annonce->titre }}</span>
                            <span class="badge bg-light text-secondary border font-monospace" style="font-size:0.65rem;">{{ $annonce->cible_niveau ?? 'Global' }}</span>
                        </div>
                        <p class="text-muted mb-0 small" style="font-size:0.8rem;">{{ Str::limit($annonce->contenu, 80) }}</p>
                    </div>
                @empty
                    <p class="text-muted text-center py-3 small">Aucune annonce envoyée récemment.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
