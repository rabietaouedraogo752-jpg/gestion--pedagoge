@extends('Layouts.mespages')
@section('content')
<form action="/matieres/envoyer" method="POST" class="card p-4 shadow-sm">
    @csrf
    <div class="mb-3">
        <label for="nom" class="form-label">Nom de la matière</label>
        <input type="text" name="nom_matiere" class="form-control" placeholder="Ex: Mathématiques">
    </div>
    <div class="mb-3">
        <label for="coef" class="form-label">Coefficient</label>
        <input type="number" name="coefficient" class="form-control" placeholder="Ex: 5">
    </div>
    <button type="submit" class="btn btn-success mb-3">Enregistrer</button> 
    <a href="/matieres" class="btn btn-secondary">Annuler</a>
</form>
@endsection