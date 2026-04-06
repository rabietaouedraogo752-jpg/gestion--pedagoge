@extends('Layouts.mespages')
@section('content')
<form action="/enseignants/modifier/{{ $enseignant->id}}" method="POST" class="card p-4 shadow-sm">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" name="nom" class="form-control" value="{{ $enseignant->nom }}">
    </div>
    <div class="mb-3">
        <label for="prenom" class="form-label">Prenom</label>
        <input type="text" name="prenom" class="form-control" value="{{ $enseignant->prenom }}">
    </div>
   
    <div class="mb-3">
        <label for="telephone" class="form-label">Télephone</label>
        <input type="text" name="telephone" class="form-control" value="{{ $enseignant->telephone }}">
    </div>
    <div class="mb-3">
        <label for="adresse" class="form-label">Adresse</label>
        <input type="text" name="adresse" class="form-control" value="{{ $enseignant->adresse}}">
    </div>
    <div class="mb-3">
        <label for="date_naissance" class="form-label">Date de naissance</label>
        <input type="date" name="date_naissance" class="form-control" value="{{ $enseignant->date_naissance }}">
    </div>
    
    
    
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ $enseignant->email }}">
    </div>
    
    <button type="submit" class="btn btn-success mb-3">Mettre à jour</button> 
    <a href="/enseignants" class="btn btn-secondary">Annuler</a>
</form>
@endsection