@extends('Layouts.app')
@section('title', 'Mon Profil')
@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Mon Profil</h5>
                <a href="{{ route('profil.edit') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-pencil me-1"></i>Modifier
                </a>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center mb-3">
                        <img src="{{ $user->photo_url }}" alt="Photo"
                            class="avatar-circle mb-2" style="width:100px;height:100px;">
                        <div><span class="badge bg-primary fs-6">{{ ucfirst($user->role) }}</span></div>
                    </div>
                    <div class="col-md-9">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-semibold text-muted" width="40%"><i class="bi bi-person me-2"></i>Nom complet</td>
                                <td>{{ $user->nom_complet }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted"><i class="bi bi-envelope me-2"></i>Email</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted"><i class="bi bi-telephone me-2"></i>Téléphone</td>
                                <td>{{ $user->telephone ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted">
                                <i class="bi bi-book me-2"></i>Niveau d'étude
                                </td>
                                <td>
                                @if($user->isEtudiant())
                                   {{ $user->niveau ?? '—' }}
                                @else
                                   <span class="text-muted">Non applicable</span>
                                @endif
                               </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted"><i class="bi bi-geo-alt me-2"></i>Adresse</td>
                                <td>{{ $user->adresse ?? '—' }}</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted"><i class="bi bi-calendar me-2"></i>Date de naissance</td>
                                
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted"><i class="bi bi-clock me-2"></i>Membre depuis</td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Changer mot de passe --}}
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Changer le mot de passe</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profil.password') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mot de passe actuel</label>
                        <input type="password" name="current_password"
                            class="form-control @error('current_password') is-invalid @enderror">
                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nouveau mot de passe</label>
                            <input type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Minimum 8 caractères">
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Confirmer</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-shield-check me-2"></i>Mettre à jour
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection