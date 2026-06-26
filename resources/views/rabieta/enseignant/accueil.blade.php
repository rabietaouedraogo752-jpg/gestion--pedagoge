@extends('Layouts.mespages')
@section('content')

<style>
    /* Style pour les onglets actifs */
    .nav-tabs .nav-link.active {
        color: #0d6efd !important;
        font-weight: bold;
        border-bottom: 3px solid #0d6efd !important;
    }
    .nav-tabs .nav-link {
        color: #495057;
    }
</style>

<div class="container-fluid py-4">
    <!-- En-tête -->
    <div class="bg-white p-3 border rounded d-flex justify-content-between align-items-center shadow-sm mb-4">
        <h4 class="fw-bold mb-0"><i class="bi bi-person-workspace me-2"></i>Mon Espace Enseignant(e)</h4>
        <span class="badge bg-primary p-2">Session Active</span>
    </div>

    <!-- 📑 SYSTÈME D'ONGLETS INTERACTIFS -->
    <ul class="nav nav-tabs mb-4" id="teacherTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="courses-tab" data-bs-toggle="tab" data-bs-target="#courses-content" type="button" role="tab" aria-controls="courses-content" aria-selected="true">
                <i class="bi bi-journal-bookmark-fill me-2"></i>Mes Cours Assignés
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="announcements-tab" data-bs-toggle="tab" data-bs-target="#announcements-content" type="button" role="tab" aria-controls="announcements-content" aria-selected="false">
                <i class="bi bi-bell-fill text-warning me-2"></i>Espace Communications
            </button>
        </li>
    </ul>

    <!-- 📦 CONTENU DES ONGLETS -->
    <div class="tab-content" id="teacherTabContent">
        
        <!-- === ONGLET 1 : LES COURS ASSIGNÉS === -->
        <div class="tab-pane fade show active" id="courses-content" role="tabpanel" aria-labelledby="courses-tab">
            <div class="row g-4">
                @forelse($mesCours as $c)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 border-top border-primary border-4 bg-white">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div>
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-light text-primary border">{{ $c->niveau }}</span>
                                    <span class="badge bg-light text-secondary border font-monospace" style="font-size: 0.75rem;">{{ $c->horaire }}</span>
                                </div>
                                <h5 class="fw-bold text-dark mb-1">{{ $c->matiere->nom_matiere ?? 'Module' }}</h5>
                                <p class="text-muted small mb-3"><i class="bi bi-calendar-event me-1"></i> Jour de cours : {{ $c->jour }}</p>
                            </div>
                            
                            <div class="d-grid gap-2 mt-3">
                                <a href="/enseignant/cours/{{ $c->id }}/notes" class="btn btn-outline-success btn-sm fw-bold">
                                    <i class="bi bi-pencil-square me-1"></i> Saisir les notes
                                </a>
                                <a href="/enseignant/cours/{{ $c->id }}/contenu" class="btn btn-outline-primary btn-sm fw-bold">
                                    <i class="bi bi-file-earmark-plus me-1"></i> Ajouter du contenu
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted py-4 bg-white rounded border shadow-sm">
                        <i class="bi bi-folder-x text-muted" style="font-size: 2.5rem;"></i>
                        <p class="mt-2 mb-0 fw-semibold">Aucun cours ne vous a été attribué pour le moment.</p>
                    </div>
                </div>
                @endforelse
            </div>
        </div>

        <!-- === ONGLET 2 : COMMUNICATIONS (PARTAGE ET RECEPTION) === -->
        <div class="tab-pane fade" id="announcements-content" role="tabpanel" aria-labelledby="announcements-tab">
            <div class="row g-4">
                
                <!-- Formulaire de Publication (À gauche) -->
                <div class="col-lg-5">
                    <div class="card p-4 border-0 shadow-sm bg-white">
                        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-send-fill me-2"></i>Partager une information</h5>
                        
                        <!-- Redirection vers la route d'envoi globale autorisée -->
                        <form action="/chef/annonces/envoyer" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Objet / Titre</label>
                                <input type="text" name="titre" class="form-control" placeholder="ex: Consignes pour le projet de fin d'année" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Classe Cible</label>
                                <select name="cible_niveau" class="form-select" required>
                                    <option value="">-- Choisir le public cible --</option>
                                    <option value="Global">📢 Tout l'établissement</option>
                                    <!-- Permet de charger dynamiquement les niveaux des cours de cet enseignant -->
                                    @foreach($mesCours->pluck('niveau')->unique() as $niveau)
                                        <option value="{{ $niveau }}">Étudiants en {{ $niveau }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small fw-bold">Message</label>
                                <textarea name="contenu" class="form-control" rows="4" placeholder="Saisissez votre communiqué ou consigne ici..." required></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 fw-bold">Diffuser l'information</button>
                        </form>
                    </div>
                </div>

                <!-- Réception du Flux (À droite) -->
                <div class="col-lg-7">
                    <div class="card p-4 border-0 shadow-sm bg-white" style="max-height: 480px; overflow-y: auto;">
                        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-history me-2"></i>Flux des communications reçues</h5>
                        
                        @forelse($annonces ?? [] as $a)
                            <!-- L'enseignant reçoit les messages destinés aux Enseignants ou Globaux -->
                            @if($a->cible_niveau == 'Enseignants' || $a->cible_niveau == 'Global' || empty($a->cible_niveau) || $a->cible_niveau == '')
                            <div class="p-3 mb-3 rounded bg-light border-start border-4 border-warning">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <h6 class="fw-bold text-dark mb-0">{{ $a->titre }}</h6>
                                    <small class="text-muted font-monospace" style="font-size: 0.75rem;">
                                        {{ $a->created_at ? $a->created_at->format('d/m/Y') : 'Date N/A' }}
                                    </small>
                                </div>
                                <p class="text-secondary mb-0 small" style="line-height: 1.4;">{{ $a->contenu }}</p>
                            </div>
                            @endif
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-chat-left-dots" style="font-size: 2rem;"></i>
                                <p class="mt-2 mb-0 small">Aucune note d'information reçue actuellement.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
