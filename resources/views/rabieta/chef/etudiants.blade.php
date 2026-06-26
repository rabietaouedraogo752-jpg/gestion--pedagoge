@extends('Layouts.mespages')
@section('content')

<div class="container py-4">
    <h3 class="text-primary fw-bold mb-4">
        <i class="bi bi-people-fill me-2"></i>Étudiants sectorisés par Filière et Niveau
    </h3>
    
    <div class="card border-0 shadow-sm bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Filière / Spécialité</th> 
                        <th>Niveau d'étude</th>       
                    </tr>
                </thead>
                <tbody>
                    @forelse($etudiants as $e)
                        <tr>
                            <td class="fw-bold text-dark">{{ $e->nom }}</td>
                            <td>{{ $e->prenom }}</td>
                            <td><span class="text-muted">{{ $e->email }}</span></td>
                            <td>
                                <!-- Détection intelligente de la filière textuelle -->
                                <span class="badge bg-light text-dark border p-2 fw-semibold">
                                    <i class="bi bi-folder2 text-warning me-1"></i> 
                                    @if(!empty($e->filiere) && !str_contains($e->filiere, 'Licence') && !str_contains($e->filiere, 'Master'))
                                        {{ $e->filiere }}
                                    @elseif(!empty($e->niveau) && !str_contains($e->niveau, 'Licence') && !str_contains($e->niveau, 'Master'))
                                        {{ $e->niveau }}
                                    @else
                                        Général
                                    @endif
                                </span>
                            </td>
                            <td>
                                <!-- Détection intelligente de l'année d'étude (Licence/Master) -->
                                <span class="badge bg-info text-dark p-2 fw-semibold">
                                    <i class="bi bi-mortarboard-fill me-1"></i> 
                                    @if(!empty($e->niveau) && (str_contains($e->niveau, 'Licence') || str_contains($e->niveau, 'Master')))
                                        {{ $e->niveau }}
                                    @elseif(!empty($e->filiere) && (str_contains($e->filiere, 'Licence') || str_contains($e->filiere, 'Master')))
                                        {{ $e->filiere }}
                                    @else
                                        Licence / Non spécifié
                                    @endif
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-info-circle me-2"></i> Aucun étudiant enregistré dans votre département.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
