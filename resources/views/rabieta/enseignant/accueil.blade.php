@extends('Layouts.mespages')
@section('content')

<div class="container-fluid py-4">
    <h3 class="fw-bold text-primary mb-4">Mon Espace Enseignant</h3>

    <div class="row g-4">
        @forelse($mesCours as $c)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 shadow-sm border-0 border-top border-primary border-4">
                <div class="card-body">
                    <span class="badge bg-light text-primary border mb-2">{{ $c->niveau }}</span>
                    <h5 class="fw-bold mb-1">{{ $c->titre }}</h5>
                    <p class="text-muted small">{{ $c->matiere->nom_matiere ?? '' }}</p>
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <!-- Bouton pour ajouter du contenu -->
                        <a href="/enseignant/cours/{{ $c->id }}/contenu" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-file-earmark-plus me-1"></i> Ajouter du contenu
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted">Aucun cours ne vous a été attribué pour le moment.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
