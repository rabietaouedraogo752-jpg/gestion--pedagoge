@extends('davy.gestion.Layouts.app')
@section('title', 'Validation des comptes')
@section('content')

<div class="container-fluid">
    <h3 class="fw-bold text-primary mb-4">
        <i class="bi bi-shield-check me-2"></i>Validation des Comptes Utilisateurs
    </h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm bg-white">
        <div class="card-header bg-white border-0 pt-3">
            <h5 class="fw-bold text-secondary mb-0">Demandes d'inscription en attente</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th class="text-start ps-4">Utilisateur</th>
                            <th>Email</th>
                            <th>Rôle demandé</th>
                            <th>Date d'inscription</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($utilisateursEnAttente as $u)
                        <tr>
                            <td class="fw-bold text-dark text-start ps-4">
                                <i class="bi bi-person-fill text-secondary me-2"></i>{{ $u->nom }} {{ $u->prenom }}
                            </td>
                            <td><span class="text-muted font-monospace">{{ $u->email }}</span></td>
                            <td>
                                @if($u->role == 'chef_departement')
                                    <span class="badge bg-purple text-white" style="background-color: #6f42c1;">Chef Département</span>
                                @elseif($u->role == 'enseignant')
                                    <span class="badge bg-warning text-dark">Enseignant</span>
                                @else
                                    <span class="badge bg-success">Étudiant</span>
                                @endif
                            </td>
                            <td>{{ $u->created_at ? $u->created_at->format('d/m/Y H:i') : 'Inconnue' }}</td>
                            <td>
                                <!-- Bouton Action pour valider -->
                                <form action="/admin/valider-compte/{{ $u->id }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success px-3 fw-bold shadow-sm" onclick="return confirm('Autoriser cet utilisateur à se connecter ?')">
                                        <i class="bi bi-check-lg me-1"></i> Valider l'accès
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-check2-all text-success fs-3 d-block mb-2"></i>
                                Aucun compte en attente de validation. Tout est à jour !
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
