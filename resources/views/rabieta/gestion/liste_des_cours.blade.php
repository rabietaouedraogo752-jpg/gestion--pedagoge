@extends('Layouts.mespages')
@section('content')
<div class="card mb-4 shadow-sm">
    <div class="card-body">
        <form action="{{ url('/cours') }}" method="GET" class="row g-3">
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

<h2 class="text-center mb-5 border  border-3 border-primary text-primary w-50 mx-auto p-2 rounded"> Liste des cours</h2>
   <div class="d-flex justify-content-between align-items-center mb-3">
        
        <a  class="btn btn-primary" href="/cours/creer">Ajouter un cours</a>
        <form action="/cours" method="GET" class="d-flex mb-3">
              <input type="text" name="search" class="form-control me-2" placeholder= "Rechercher un cours" value="{{ request('search')}}">
              <button type="submit" class="btn btn-outline-primary">Rechercher</button>
              <a href="/cours" class="btn btn-outline-secondary ms-2">Réinitialiser</a>
        
        </form>

</div>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Titre du Cours</th>
                        <th>Matière</th>
                        <th>Enseignant</th>
                        <th>Niveau</th>
                        <th>Jour</th>
                        <th>Horaire</th>
                        <th class="text-center">Gestion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($les_cours as $c)
                    <tr>
                        <td class="fw-bold">{{ $c->titre }}</td>
                        <td><span class="badge bg-info text-dark">{{ $c->matiere->nom_matiere ?? 'N/A' }}</span></td>
                        <td>{{ $c->enseignant->prenom ?? '' }} {{ $c->enseignant->nom ?? 'Inconnu' }}</td>
                        <td>{{ $c->niveau }}</td>
                        <td>{{ $c->jour}}</td>
                        <td>{{ $c->horaire}}</td>
                        <td class="text-center">
                            <a href="/cours/modifier/{{ $c->id }}" class="btn btn-sm btn-info text-white" >Modifier</a>;
                            <form action="/cours/supprimer/{{ $c->id}}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce cours?')">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-info-circle me-1"></i> Aucun cours n'a été créé pour le moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
