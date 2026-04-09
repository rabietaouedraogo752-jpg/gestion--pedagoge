@extends('Layouts.mespages')
@section('content')
<h2 class="text-center mb-5 border  border-3 border-primary text-primary w-50 mx-auto p-2 rounded"> Liste des matières</h2>
   <div class="d-flex justify-content-between align-items-center mb-3">
        
        <a class="btn btn-primary" href="/matieres/creer">Ajouter une matière</a>
        <form action="/matieres" method="GET" class="d-flex mb-3">
              <input type="text" name="search" class="form-control me-2" placeholder ="Rechercher une matière" value="{{ request('search')}}">
              <button type="submit" class="btn btn-outline-primary">Rechercher</button>
              <a href="/matieres" class="btn btn-outline-secondary ms-2">Réinitialiser</a>
        
        </form>

</div>        
  

   <table class="table table-striped table-hover mt-3">
   <thead class="table-primary">
      <th>#</th>
      <th>Nom de la matière</th>
      <th>Coefficient</th>
      <th>Gestion</th>
   </thead>
   <tbody>
    @foreach($toutesMatieres as $matiere)
    <tr>
        <td>{{ $matiere->id }}</td>
        <td>{{ $matiere->nom_matiere }}</td>
        <td>{{ $matiere->coefficient }}</td>
        <td>
            <a href="/matieres/modifier/{{ $matiere->id }}" class="btn btn-sm btn-info text-white" >Modifier</a>;
            <form action="/matieres/supprimer/{{ $matiere->id}}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette matière?')">Supprimer</button>
            </form>
        </td>
    </tr>
    @endforeach
   </tbody>
</table>

@endsection