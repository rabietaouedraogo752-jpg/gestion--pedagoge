@extends('Layouts.mespages')
@section('content')
<form action="/etudiants/envoyer" method="POST" class="card p-4 shadow-sm">
    @csrf
    <div class="mb-3">
        <label for="nom" class="form-label">Nom</label>
        <input type="text" name="nom" class="form-control" placeholder="Ex: OUEDRAOGO">
    </div>
    <div class="mb-3">
        <label for="prenom" class="form-label">Prenom</label>
        <input type="text" name="nom" class="form-control" placeholder="Ex: Rabièta">
    </div>
    <div class="mb-3">
        <label for="niveau" class="form-label">Niveau</label>
        <input type="text" name="niveau" class="form-control" placeholder="Ex: Licence 1">
    </div>
    <div class="mb-3">
        <label for="telephone" class="form-label">Télephone</label>
        <input type="number" name="telephone" class="form-control" placeholder="Ex: 52895999">
    </div>
    <div class="mb-3">
        <label for="adresse" class="form-label">Adresse</label>
        <input type="text" name="adresse" class="form-control" placeholder="Ex: secteure 19">
    </div>
    <div class="mb-3">
        <label for="date_de naissance" class="form-label">Date de naissance</label>
        <input type="date" name="date_naissance" class="form-control" >
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" class="form-control" >
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Mot de Passe</label>
        <input type="password" name="password" class="form-control" >
    </div>
    <button type="submit" class="btn btn-success mb-3">Enregistrer</button> 
    <a href="/etudiants" class="btn btn-secondary">Annuler</a>
</form>
@endsection