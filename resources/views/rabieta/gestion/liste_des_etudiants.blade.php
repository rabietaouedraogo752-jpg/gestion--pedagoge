@extends('Layouts.mespages')
@section('content')
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form action="{{ url('/etudiants') }}" method="GET" class="row g-3">
            <div class="col-md-8">
                <select name="niveau" class="form-select">
                    <option value="">sélectionner un niveau</option>
                    <option value="Licence 1">Licence 1</option>
                    <option value="Licence 2">Licence 2</option>
                    <option value="Licence 3">Licence 3</option>
                    <option value="Master 1">Master 1</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Appliquer le filtre
                </button>
            </div>
        </form>
    </div>
</div>

<h2 class="text-center mb-5 border  border-3 border-primary text-primary w-50 mx-auto p-2 rounded"> Liste des étudiants(es)</h2>
   <div class="d-flex justify-content-between align-items-center mb-3">
        
        <a  class="btn btn-primary" href="/etudiants/creer">Ajouter un(e) étudiant(e)</a>
        <form action="/etudiants" method="GET" class="d-flex mb-3">
              <input type="text" name="search" class="form-control me-2" placeholder= "Rechercher un(e) étudiant(e)" value="{{ request('search')}}">
              <button type="submit" class="btn btn-outline-primary">Rechercher</button>
              <a href="/etudiants" class="btn btn-outline-secondary ms-2">Réinitialiser</a>
        
        </form>

</div>        
   
   <table class="table table-striped table-hover mt-3">
   <thead class="table-primary">
      <th>#</th>
      <th>Nom</th>
      <th>Prenom</th>
      <th>Email</th>
       <th>Telephone</th>
      <th>Adresse</th>
      <th>Date de naissance</th>
      <th>Photo</th>
      <th>Gestion</th>
   </thead>
   <tbody>
    @foreach($etudiants as $etudiant)
    <tr>
        <td>{{ $etudiant->id }}</td>
        <td>{{ $etudiant->nom}}</td>
        <td>{{ $etudiant->prenom}}</td>
        <td>{{ $etudiant->email}}</td>
        <td>{{ $etudiant->telephone}}</td>
        <td>{{ $etudiant->adresse}}</td>
        <td>{{ \carbon\carbon::parse($etudiant->date_naissance)->format('d/m/y')}}</td>
        <td>{{ $etudiant->photo}}</td>
        
        <td>
            <a href="/etudiants/modifier/{{ $etudiant->id }}" class="btn btn-sm btn-info text-white" >Modifier</a>;
            <form action="/etudiants/supprimer/{{ $etudiant->id}}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet étudiant?')">Supprimer</button>
            </form>
        </td>
    </tr>
    @endforeach
   </tbody>
</table>

@endsection