@extends('Layouts.mespages')
@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="text-primary fw-bold">Liste des Départements</h3>
    <a href="/departements/creer" class="btn btn-primary"><i class="bi bi-plus-lg me-2"></i>Nouveau Département</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nom du Département</th>
                    <th>Filières</th>
                    <th>Chef de Département</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departements as $d)
                <tr>
                    <td class="fw-bold">{{ $d->nom_departement }}</td>
                    <td><span class="badge bg-secondary">{{ $d->filieres }}</span></td>
                    <td>
                        <i class="bi bi-person-badge text-primary me-2"></i>
                        {{ $d->chef->prenom ?? 'Aucun' }} {{ $d->chef->nom ?? '' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center py-4 text-muted">Aucun département enregistré pour le moment.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
