@extends('Layouts.mespages')

@section('content')
<style>
    /* Design des cartes de cours (Vignettes) */
    .course-card {
        transition: transform 0.3s;
        border-radius: 12px;
        border: none;
        overflow: hidden;
    }
    
    .course-banner {
        height: 110px;
        background: linear-gradient(135deg, #0d47a1, #42a5f5);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        text-transform: uppercase;
        padding: 15px;
        text-align: center;
        font-size: 0.85rem;
    }
    .section-title {
        color: #b71c1c; /* Rouge Moodle */
        font-weight: 700;
        border-bottom: 2px solid #eeeeee;
        padding-bottom: 8px;
        margin-bottom: 20px;
    }
</style>

<div class="container-fluid py-4">
    <!-- j'ai mis ce bloc qui controle l'affichage du tableau de bord-->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white p-3 border rounded d-flex justify-content-between align-items-center">
                <h4 class=" fw-bold"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</h4>
                <span class="badge bg-light text-dark border p-2">
                    <i class="bi bi-mortarboard me-1"></i> {{ Auth::user()->niveau }}
                </span>
            </div>
        </div>
    </div>
        <!-- 📑 À AJOUTER ICI : BARRE DES ONGLES INTERACTIFS -->
    <ul class="nav nav-tabs mb-4" id="studentTab" role="tablist" style="border-bottom: 2px solid #eeeeee;">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold text-primary" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-content" type="button" role="tab" aria-controls="home-content" aria-selected="true">
                <i class="bi bi-grid-1x2-fill me-2"></i>Mes Cours & Notes
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold text-secondary" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule-content" type="button" role="tab" aria-controls="schedule-content" aria-selected="false">
                <i class="bi bi-calendar3 me-2"></i>Emploi du temps complet
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold text-secondary" id="announcements-tab" data-bs-toggle="tab" data-bs-target="#announcements-content" type="button" role="tab" aria-controls="announcements-content" aria-selected="false">
                <i class="bi bi-bell-fill text-danger me-2"></i>Annonces & Communiqués
            </button>
        </li>
    </ul>

    <!-- 📦 OUVERTURE DE l'ENVELOPPE DES CONTENUS -->
    <div class="tab-content" id="studentTabContent">
        
        <!-- === CONTENU ONGLET 1 : TON AFFICHAGE ACTUEL === -->
        <div class="tab-pane fade show active" id="home-content" role="tabpanel" aria-labelledby="home-tab">


    <div class="row g-4">
    
        <div class="col-lg-8 border">
            
            <!-- Ce bloc me permets de controller la partie de mes cours-->
            <h5 class="section-title">Mes cours ({{ Auth::user()->niveau }})</h5>
            <div class="row g-3 mb-5">
                @forelse($mesCours as $c)
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 border course-card">
                        <div class="course-banner">
                            {{ $c->matiere->nom_matiere ?? 'Général' }}
                        </div>
                        <div class="card-body p-3">
                            <small class="text-muted d-block mb-1" style="font-size: 0.7rem;">
                                {{ $c->niveau }} • {{ $c->matiere->nom_matiere ?? '' }}
                            </small>
                            <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">{{ $c->titre }}</h6>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3">
                            <a href="/etudiant/cours/{{ $c->id }}" class="btn btn-sm btn-outline-primary w-100">Accéder</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info border-0 shadow-sm">
                        <i class="bi bi-info-circle me-2"></i> Aucun cours n'est programmé pour le niveau {{ Auth::user()->niveau }}.
                    </div>
                </div>
                @endforelse
            </div>

    
            
        </div>

        <!-- Ce bloc est dedié à l'affichage de l'emploi du temps et des notes-->
        <div class="col-lg-4 ">
            <h5 class="section-title">Emploi du temps de la semaine</h5>
            <div class="card border-0 border">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr class="small">
                                <th>Jour</th>
                                <th>Matière</th>
                                <th>Cours</th>
                                <th>Horaire</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mesCours as $c)
                            <tr>
                                <td class="fw-bold text-primary">{{ $c->jour }}</td>
                                <td>{{ $c->matiere->nom_matiere ?? '' }}</td>
                                <td>{{ $c->titre }}</td>
                                <td><span class="badge bg-light text-dark border">{{ $c->horaire }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- c'est le bloc de controlle spécifique des notes -->
            <h5 class="section-title">Mes Notes</h5>
            <div class="card border-0 border">
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <tbody>
                            @forelse($mesNotes as $n)
                            <tr>
                                <td class="ps-3 py-2 small">{{ $n->matiere->nom_matiere ?? 'N/A' }}</td>
                                <td class="text-end pe-3">
                                    <span class="fw-bold {{ $n->valeur >= 10 ? 'text-success' : 'text-danger' }}">
                                        {{ $n->valeur_note }}/20
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td class="text-center py-3 text-muted small">Pas encore de notes.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
        </div> <!-- FERMETURE DE L'ONGLET 1 -->

        <!-- === CONTENU ONGLET 2 : EMPLOI DU TEMPS EN GRAND === -->
        <div class="tab-pane fade" id="schedule-content" role="tabpanel" aria-labelledby="schedule-tab">
            <h5 class="section-title"><i class="bi bi-calendar3 me-2"></i>Mon Planning Hebdomadaire</h5>
            <div class="card border shadow-sm bg-white">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th class="ps-3">Jour</th>
                                <th>Matière / Module</th>
                                <th>Cours / Code</th>
                                <th>Plage Horaire</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mesCours as $c)
                            <tr>
                                <td class="fw-bold text-primary ps-3">{{ $c->jour }}</td>
                                <td class="fw-semibold">{{ $c->matiere->nom_matiere ?? 'Général' }}</td>
                                <td>{{ $c->titre }}</td>
                                <td><span class="badge bg-light text-dark border p-2 font-monospace">{{ $c->horaire }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="bi bi-calendar-x me-2"></i>Aucun emploi du temps disponible pour le moment.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- === CONTENU ONGLET 3 : TABLEAU DES ANNONCES === -->
        <div class="tab-pane fade" id="announcements-content" role="tabpanel" aria-labelledby="announcements-tab">
            <h5 class="section-title"><i class="bi bi-megaphone-fill me-2"></i>Tableau d'affichage du Département</h5>
            <div class="row g-3">
                @forelse($annonces as $a)
                    <div class="col-12">
                        <div class="p-3 bg-white rounded shadow-sm border border-start border-4 border-danger">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold text-dark mb-0">{{ $a->titre }}</h6>
                                <small class="text-muted font-monospace" style="font-size: 0.75rem;">
                                    <i class="bi bi-calendar3 me-1"></i>{{ $a->created_at->format('d/m/Y') }}
                                </small>
                            </div>
                            <p class="text-secondary mb-0 small">{{ $a->contenu }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light text-center py-5 border shadow-sm bg-white">
                            <i class="bi bi-chat-left-dots text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2 mb-0">Aucun communiqué officiel n'a été publié pour votre filière.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </div> <!-- FERMETURE FINALE DE L'ENVELOPPE DES CONTENUS -->

@endsection
