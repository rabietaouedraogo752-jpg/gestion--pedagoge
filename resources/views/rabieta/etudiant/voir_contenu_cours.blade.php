@extends('Layouts.mespages')
@section('content')
<div class="container py-4">
    <div class="mb-4">
        <a href="/test-etudiant" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left"></i> Retour</a>
        <h2 class="fw-bold text-primary mt-2">{{ $leCour->titre }}</h2>
        <span class="badge bg-light text-dark border">{{ $leCour->matiere->nom_matiere ?? '' }}</span>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @forelse($leCour->contenus as $index => $chapitre)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold text-danger">Chapitre {{ $index + 1 }} : {{ $chapitre->titre_du_chapitre }}</h5>
                    </div>
                    <div class="card-body">
                        <!-- je vais permettre  d'afficher le contenu du texte-->
                        <div class="mb-4" style="white-space: pre-line; line-height: 1.6;">
                            {{ $chapitre->contenu_du_cours }}
                        </div>

                        <!-- je mets un bouton de téléchargement si le cours a du contenu-->
                        @if($chapitre->fichier_joint)
                            <div class="p-3 bg-light rounded d-flex justify-content-between align-items-center border">
                                <div>
                                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                                    <span class="small fw-bold">Support de cours (PDF/Image)</span>
                                </div>
                                <a href="{{ asset('uploads/cours/'.$chapitre->fichier_joint) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="bi bi-download"></i> Télécharger / Ouvrir
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="alert alert-info">Aucun contenu n'a encore été publié pour ce cours.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
