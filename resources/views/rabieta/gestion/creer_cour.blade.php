@extends('Layouts.mespages')
@section('content')

<div class="card p-4 shadow-sm">
    <h3 class="mb-4 text-primary"><i class="bi bi-plus-circle me-2"></i>Nouveau Cours</h3>

    <form action="/cours/envoyer" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Titre du cours</label>
                <input type="text" name="titre" class="form-control" placeholder="ex: Algèbre Linéaire" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Niveau / Classe</label>
                <input type="text" name="niveau" class="form-control" placeholder="ex: Licence 1" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Matière</label>
                <select name="matiere_id" class="form-select" required>
                    <option value="">-- Choisir un module --</option>
                    @foreach($toutesMatieres as $m)
                        <option value="{{ $m->id }}">{{ $m->nom_matiere }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Enseignant</label>
                <select name="user_id" class="form-select" required>
                    <option value="">-- Choisir l'enseignant --</option>
                    @foreach($enseignants as $e)
                        <option value="{{ $e->id }}">{{ $e->prenom }} {{ $e->nom }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Jour</label>
                <input type="text" name="jour" class="form-control" placeholder="ex: Lundi" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Horaire</label>
                <input type="text" name="horaire" class="form-control" placeholder="ex: 7h-9h" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Description (Optionnel)</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">Enregistrer le cours</button>
            <a href="/cours" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

@endsection
