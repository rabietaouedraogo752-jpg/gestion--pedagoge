@extends('Layouts.mespages')
@section('content')
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form action="{{ url('/notes') }}" method="GET" class="row g-3">
            <div class="col-md-8">
                <select name="niveau" class="form-select">
                    <option value="">Sélectionner un niveau</option>
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

<h2 class="text-center mb-5 border  border-3 border-primary text-primary w-50 mx-auto p-2 rounded"> bulletin de Notes</h2>
   <div class="d-flex justify-content-between align-items-center mb-3">
        
        
        
        <form action="/notes" method="GET" class="d-flex mb-3">
              <input type="text" name="search" class="form-control me-2" placeholder= "Taper le nom de l'étudiant(e)" value="{{ request('search')}}">
              <button type="submit" class="btn btn-outline-primary">Rechercher</button>
              <a href="/notes" class="btn btn-outline-secondary ms-2">Réinitialiser</a>
        
        </form>

        

</div>        
   
   

   <table class="table table-striped table-hover mt-3">
   <thead class="table-primary">
      <th>Etudiant</th>
      @foreach($matieres as $ma)
         <th>{{ $ma->nom_matiere }}</th>
      @endforeach
      
      
      
   </thead>
   <tbody>
    @foreach($etudiants as $tu)
    <tr>
        <td>{{ $tu->nom }}</td>
        @foreach($matieres as $ma)
          <td>
           
           @if($existe = $tu->notes->where('matiere_id', $ma->id)->first())
              <span class="badge {{ $existe->valeur_note >=10 ? 'bg-success' : 'bg-danger' }}">
                {{ $existe->valeur_note }} /20
            </span>
             
        <div>
           <a href="/notes/modifier/{{ $existe->id }}" class="btn btn-sm btn-info text-white mb-1 px-2 py-0"  >Modifier</a>;
            <form action="/notes/supprimer/{{ $existe->id}}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger  mb-1 px-2 py-0" onclick="return confirm('Supprimer cette note?')">Supprimer</button>
            </form>
        </div>
           @else
              
              <a href="/notes/creer/{{ $tu->id}}/{{ $ma->id}}" class="btn btn-outline-primary">saisir une note</a>
           @endif
           </td>
        @endforeach
    </tr>
    
    </tr>
    @endforeach
   </tbody>
</table>

@endsection