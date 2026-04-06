@extends('Layouts.mespages')
@section('content')
<form action="/matieres/modifier/{{ $laMatiere->id}}" method="POST" class="card p-4 shadow-sm">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="nom" class="form-label">Nom de la matière</label>
        <input type="text" name="nom_matiere" value="{{ $laMatiere->nom_matiere }}" class="form-control">
    </div>
    
    <div class="mb-3">
        <label for="coef" class="form-label">Coefficient</label>
        <input type="number" name="coefficient" class="form-contro" value="{{ $laMatiere->coefficient }}">
    </div>
    <button type="submit" class="btn btn-success mb-3">Mettre à jour</button> 
    <a href="/matieres" class="btn btn-secondary">Annuler</a>
</form>
@endsection