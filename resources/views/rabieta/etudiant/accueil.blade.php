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
    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.1) !important;
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
    <!-- 1. TABLEAU DE BORD (En-tête) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="bg-white p-3 shadow-sm rounded d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fw-bold"><i class="bi bi-speedometer2 me-2"></i>Tableau de bord</h4>
                <span class="badge bg-light text-dark border p-2">
                    <i class="bi bi-mortarboard me-1"></i> {{ Auth::user()->niveau }}
                </span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- COLONNE GAUCHE (8/12) : COURS ET EMPLOI DU TEMPS -->
        <div class="col-lg-8">
            
            <!-- 2. MES COURS (Design Cartes/Vignettes) -->
            <h5 class="section-title">Mes cours ({{ Auth::user()->niveau }})</h5>
            <div class="row g-3 mb-5">
                @forelse($mesCours as $c)
                <div class="col-md-6 col-xl-4">
                    <div class="card h-100 shadow-sm course-card">
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
                            <a href="#" class="btn btn-sm btn-outline-primary w-100">Accéder</a>
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

        <!-- COLONNE DROITE (4/12) : CHRONOLOGIE ET NOTES -->
        <div class="col-lg-4">
            <h5 class="section-title">Emploi du temps de la semaine</h5>
            <div class="card border-0 shadow-sm">
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
            
            <!-- 5. MES NOTES -->
            <h5 class="section-title">Mes Notes</h5>
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <tbody>
                            @forelse($mesNotes as $n)
                            <tr>
                                <td class="ps-3 py-2 small">{{ $n->matiere->nom_matiere ?? 'N/A' }}</td>
                                <td class="text-end pe-3">
                                    <span class="fw-bold {{ $n->valeur >= 10 ? 'text-success' : 'text-danger' }}">
                                        {{ $n->valeur }}/20
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
@endsection
