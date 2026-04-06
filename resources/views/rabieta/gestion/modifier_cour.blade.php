@extends('Layouts.mespages')
@section('content')
<form action="/cours/modifier/{{ $leCour->id}}" method="POST" class="card p-4 shadow-sm">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="nom" class="form-label">Titre</label>
        <input type="text" name="titre" class="form-control" value="{{ $leCour->titre }}">
    </div>
    <div class="mb-3">
        <label for="niveau" class="form-label">Niveau</label>
        <input type="text" name="niveau" class="form-control" value="{{ $leCour->niveau }}">
    </div>
    
        <div class="col-md-6 mb-3">
                <label class="form-label">Enseignant(e)</label>
                <select name="user_id" class="form-select" required>
                    @foreach($enseignants as $e)
                        <option value="{{ $e->id }}" {{ $leCour->user_id == $e->id ? 'selected' : '' }}>
                            {{ $e->prenom }} {{ $e->nom }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row">
            <!-- Jour -->
            <div class="col-md-6 mb-3">
                <label for="jour" class="form-label">Jour</label>
                <select name="jour" class="form-select">
                    @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $j)
                        <option value="{{ $j }}" {{ $leCour->jour == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="horaire" class="form-label">Horaire (ex: 08h-10h)</label>
                <input type="text" name="horaire" class="form-control" value="{{ $leCour->horaire }}">
            </div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $leCour->description }}</textarea>
        </div>
    <button type="submit" class="btn btn-success mb-3">Mettre à jour</button> 
    <a href="/etudiants" class="btn btn-secondary">Annuler</a>
</form>
@endsection