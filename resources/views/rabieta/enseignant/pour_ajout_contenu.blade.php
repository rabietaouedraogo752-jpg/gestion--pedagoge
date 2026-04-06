@extends('Layouts.mespages')
@section('content')
<div class="card p-4 shadow-sm border-0">
    <h4 class="fw-bold text-primary mb-4">Publier un nouveau chapitre</h4>
    <p class="text-muted">Cours : <strong>{{ $leCour->titre }}</strong></p>

    <form action="/contenu/enregistrer" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="cour_id" value="{{ $leCour->id }}">
        
        <div class="mb-3">
            <label class="form-label">Titre du chapitre</label>
            <input type="text" name="titre_du_chapitre" class="form-control" placeholder="ex: Introduction au PHP" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contenu du cours</label>
            <textarea name="contenu_du_cours" class="form-control" rows="12" placeholder="Saisissez le contenu ici..."></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label fw-bold">Joindre un support (PDF, Image, Vidéo)</label>
            <input type="file" name="fichier_joint" class="form-control">
            <small class="text-muted">Format acceptés : pdf, jpg, png, mp4 (Max: 10Mo)</small>
        </div>

        <button type="submit" class="btn btn-primary">Mettre en ligne</button>
    </form>
</div>
@endsection
