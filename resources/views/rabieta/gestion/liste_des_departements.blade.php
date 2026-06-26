@extends('Layouts.mespages')
@section('content')

<h2 class="text-center mb-5 border border-3 border-primary text-primary w-50 mx-auto p-2 rounded fw-bold">Gestion des Départements</h2>

<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- Bouton de création -->
    <a href="/departements/creer" class="btn btn-primary shadow-sm"><i class="bi bi-plus-lg me-2"></i>Nouveau Département</a>
    
    <!-- 🔍 BARRE DE RECHERCHE INTÉGRÉE -->
    <form action="/departements" method="GET" class="d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Rechercher un pôle..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary">Rechercher</button>
        <a href="/departements" class="btn btn-outline-secondary ms-2">Réinitialiser</a>
    </form>
</div>

<div class="card border-0 shadow-sm bg-white">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Nom du Département</th>
                    <th>Filières associées</th>
                    <th>Chef de Département</th>
                    <th class="text-center">Gestion</th> <!-- Nouvelle colonne -->
                </tr>
            </thead>
            <tbody>
                @forelse($departements as $index => $d)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="fw-bold text-dark">{{ $d->nom_departement }}</td>
                    <td>
                        <!-- Découpage propre des filières textuelles en petits badges individuels -->
                        @foreach(array_map('trim', explode(',', $d->filieres)) as $filiere)
                            @if(!empty($filiere))
                                <span class="badge bg-light text-dark border me-1 my-1">
                                    <i class="bi bi-folder2 text-warning me-1"></i>{{ $filiere }}
                                </span>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <span class="fw-semibold text-secondary">
                            <i class="bi bi-person-badge-fill text-primary me-2"></i>
                            {{ $d->chef->prenom ?? 'Aucun' }} {{ $d->chef->nom ?? 'directeur affecté' }}
                        </span>
                    </td>
                    <!-- 🛠️ BOUTONS D'ACTIONS DE MODIFICATION ET DE SUPPRESSION -->
                    <td class="text-center">
                        <a href="/departements/modifier/{{ $d->id }}" class="btn btn-sm btn-info text-white me-1">
                            <i class="bi bi-pencil-square"></i> Modifier
                        </a>
                        
                        <form action="/departements/supprimer/{{ $d->id }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement le département {{ $d->nom_departement }} ?')">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="bi bi-info-circle me-2"></i> Aucun département ne correspond à votre recherche.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
