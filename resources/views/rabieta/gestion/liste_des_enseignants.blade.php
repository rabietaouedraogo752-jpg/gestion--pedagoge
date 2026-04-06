@extends('Layouts.mespages')
@section('content')
<h2 class="text-center mb-5 border  border-3 border-primary text-primary w-50 mx-auto p-2 rounded"> Liste des enseignants(es)</h2>

   <div class="d-flex justify-content-between align-items-center mb-3">
        
        <a  class="btn btn-primary" href="/enseignants/creer">Ajouter un(e) enseignant(e)</a>
        <form action="/enseignants" method="GET" class="d-flex mb-3">
              <input type="text" name="search" class="form-control me-2" placeholder= "Rechercher un(e) enseignant(e)" value="{{ request('search')}}">
              <button type="submit" class="btn btn-outline-primary">Rechercher</button>
              <a href="/enseignants" class="btn btn-outline-secondary ms-2">Réinitialiser</a>
        
        </form>

</div>        
   

   <table class="table table-bordered table-striped table-hover mt-3">
   <thead class="table-primary">
    <tr>
      <th>#</th>
      <th>Nom</th>
       <th>Prenom</th>
      <th>Email</th>
      
      <th>Specialite</th>
      <th>Telephone</th>
      <th>Adresse</th>
      <th>Date de naissance</th>
      <th>Photo</th>
      <th>Gestion</th>
    </tr>
   </thead>
   <tbody>
    @foreach($enseignants as $enseignant)
    <tr>
        <td>{{ $enseignant->id }}</td>
        <td>{{ $enseignant->nom}}</td>
        <td>{{ $enseignant->prenom}}</td>
        <td>{{ $enseignant->email}}</td>
        
        <td>{{ $enseignant->specialite}}</td>
        <td>{{ $enseignant->telephone}}</td>
        <td>{{ $enseignant->adresse}}</td>
        <td>{{ \carbon\carbon::parse($enseignant->date_naissance)->format('d/m/y')}}</td>
        <td>{{ $enseignant->photo}}</td>
        <td>
            <a href="/enseignants/modifier/{{ $enseignant->id }}" class="btn btn-sm btn-info text-white" >Modifier</a>;
            <form action="/enseignants/supprimer/{{ $enseignant->id}}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cet enseignant?')">Supprimer</button>
            </form>
        </td>
    </tr>
    @endforeach
   </tbody>
</table>

@endsection