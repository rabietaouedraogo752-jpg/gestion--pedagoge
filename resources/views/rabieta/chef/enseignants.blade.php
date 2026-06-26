@extends('Layouts.mespages')
@section('content')
<div class="container py-4">
    <h3 class="text-primary fw-bold mb-4"><i class="bi bi-person-badge me-2"></i>Corps Enseignant du Département</h3>
    <div class="card border-0 shadow-sm bg-white">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr><th>Nom</th><th>Prénom</th><th>Email</th><th>Spécialité</th></tr>
            </thead>
            <tbody>
                @forelse($enseignants as $prof)
                    <tr>
                        <td class="fw-bold">{{ $prof->nom }}</td><td>{{ $prof->prenom }}</td><td>{{ $prof->email }}</td>
                        <td><span class="badge bg-secondary">{{ $prof->specialite ?? 'Général' }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted py-3">Aucun enseignant affecté à vos cours.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
