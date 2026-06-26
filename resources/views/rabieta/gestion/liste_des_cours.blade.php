@extends('Layouts.mespages')
@section('content')

<div class="card mb-4 shadow-sm border-0">
    <div class="card-body">
        <form action="{{ url('/cours') }}" method="GET" class="row g-3">
            <div class="col-md-8">
                <select name="niveau" class="form-select">
                    <option value="">sélectionner un niveau d'étude</option>
                    <option value="Licence 1" {{ request('niveau') == 'Licence 1' ? 'selected' : '' }}>Licence 1</option>
                    <option value="Licence 2" {{ request('niveau') == 'Licence 2' ? 'selected' : '' }}>Licence 2</option>
                    <option value="Licence 3" {{ request('niveau') == 'Licence 3' ? 'selected' : '' }}>Licence 3</option>
                    <option value="Master 1" {{ request('niveau') == 'Master 1' ? 'selected' : '' }}>Master 1</option>
                    <option value="Master 2" {{ request('niveau') == 'Master 2' ? 'selected' : '' }}>Master 2</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter"></i> Appliquer le filtre
                </button>
            </div>
        </form>
    </div>
</div>

<h2 class="text-center mb-4 border border-3 border-primary text-primary w-50 mx-auto p-2 rounded fw-bold">Planning des Cours</h2>

<div class="d-flex justify-content-between align-items-center mb-3">
    <a class="btn btn-primary" href="/cours/creer"><i class="bi bi-plus-lg me-1"></i> Ajouter un cours</a>
    
    <form action="/cours" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Rechercher par filière..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary">Rechercher</button>
        <a href="/cours" class="btn btn-outline-secondary ms-2">Réinitialiser</a>
    </form>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-primary">
                <tr>
                    <th>Matière / Module</th>
                    <th>Filière</th>
                    <th>Enseignant</th>
                    <th>Niveau d'étude</th>
                    <th>Jour</th>
                    <th>Horaire</th>
                    <th class="text-center">Gestion</th>
                </tr>
            </thead>
            <tbody>
                @forelse($les_cours as $c)
                <tr>
                    <!-- Affichage du nom de la matière (ce qui remplace le titre) -->
                    <td class="fw-bold text-dark">{{ $c->matiere->nom_matiere ?? 'Matière non spécifiée' }}</td>
                    
                    <!-- Affichage de la filière sectorisée -->
                    <td>
                        <span class="badge bg-light text-dark border p-2 fw-semibold">
                            <i class="bi bi-folder2 text-warning me-1"></i> {{ $c->filiere ?? 'Général' }}
                        </span>
                    </td>
                    
                    <!-- Affichage de l'enseignant -->
                    <td>
                        <i class="bi bi-person text-secondary me-1"></i>
                        {{ $c->enseignant->prenom ?? '' }} {{ $c->enseignant->nom ?? 'Non assigné' }}
                    </td>
                    
                    <!-- Niveau d'étude -->
                    <td><span class="badge bg-info text-dark p-2">{{ $c->niveau ?? 'N/A' }}</span></td>
                    
                    <!-- Jour de la semaine -->
                    <td class="text-primary fw-semibold">{{ $c->jour }}</td>
                    
                    <!-- Plage horaire -->
                    <td><span class="badge bg-secondary font-monospace p-2">{{ $c->horaire }}</span></td>
                    
                    <td class="text-center">
                        <a href="/cours/modifier/{{ $c->id }}" class="btn btn-sm btn-info text-white me-1">Modifier</a>
                        
 <!-- LE NOUVEAU BOUTON À PLACER DANS TON TABLEAU -->
<a href="/cours/action/supprimer/{{ $c->id }}" class="btn btn-sm btn-danger fw-bold" 
   onclick="return confirm('Êtes-vous sûr de vouloir retirer ce cours du planning ?')">
    <i class="bi bi-trash-fill me-1"></i> Supprimer
</a>


                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-info-circle me-1"></i> Aucun cours ne correspond à vos filières pour le moment.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
