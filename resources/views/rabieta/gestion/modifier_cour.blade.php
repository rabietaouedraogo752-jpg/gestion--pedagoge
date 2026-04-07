@extends('Layouts.mespages')
@section('content')

<div class="card p-4 shadow-sm border-0">
    <h3 class="mb-4 text-primary fw-bold"><i class="bi bi-pencil-square me-2"></i>Modifier le Cours</h3>

    <form action="/cours/modifier/{{ $leCour->id }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Ligne 1 : Titre et Niveau -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Titre</label>
                <input type="text" name="titre" class="form-control" value="{{ $leCour->titre }}">
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Niveau</label>
                <input type="text" name="niveau" class="form-control" value="{{ $leCour->niveau }}">
            </div>
        </div>

        <!-- Ligne 2 : Enseignant et Matière -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Enseignant(e)</label>
                <select name="user_id" class="form-select">
                    @foreach($enseignants as $e)
                        <option value="{{ $e->id }}" {{ $leCour->user_id == $e->id ? 'selected' : '' }}>
                            {{ $e->prenom }} {{ $e->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Matière</label>
                <select name="matiere_id" class="form-select">
                    @foreach($toutesMatieres as $m)
                        <option value="{{ $m->id }}" {{ $leCour->matiere_id == $m->id ? 'selected' : '' }}>
                            {{ $m->nom_matiere }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Ligne 3 : Jour et Horaire -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-bold">Jour</label>
                <select name="jour" class="form-select">
                    @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $j)
                        <option value="{{ $j }}" {{ $leCour->jour == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">Horaire (ex: 08h-10h)</label>
                <input type="text" name="horaire" class="form-control" value="{{ $leCour->horaire }}">
            </div>
        </div>

        <!-- Ligne 4 : Description -->
        <div class="mb-4">
            <label class="form-label fw-bold">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $leCour->description }}</textarea>
        </div>

        <!-- Boutons -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success px-4">Mettre à jour</button> 
            <a href="/cours" class="btn btn-secondary px-4">Annuler</a>
        </div>
    </form>
</div>

@endsection
