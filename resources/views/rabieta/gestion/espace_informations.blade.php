@extends('Layouts.mespages')
@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary fw-bold"><i class="bi bi-shield-lock-fill text-warning me-2"></i>Espace Info de l'Administration</h3>
        <a href="/dashboard" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Retour au Tableau de bord</a>
    </div>

    <div class="row g-4">
        <!-- FORMULAIRE DE PUBLICATION CIBLÉE (À gauche) -->
        <div class="col-lg-5">
            <div class="card p-4 border-0 shadow-sm bg-white">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-send-fill me-2"></i>Diffuser un communiqué</h5>
                
                <form action="/admin/annonces/enregistrer" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Titre du communiqué</label>
                        <input type="text" name="titre" class="form-control" placeholder="ex: Note de service n°04" required>
                    </div>

                    <!-- Choix du public cible -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold">À qui voulez-vous partager ce message ?</label>
                        <select name="cible_niveau" class="form-select" required>
                            <option value="">-- Sélectionner l'audience --</option>
                            <option value="Global">📢 Toute l'université (Étudiants & Enseignants)</option>
                            <option value="Enseignants">👨‍🏫 Uniquement le Corps Enseignant</option>
                            <optgroup label="Filtrer par Filière d'étudiants">
                                @foreach($toutesLesFilieres as $filiere)
                                    <option value="{{ $filiere }}">Étudiants en {{ $filiere }}</option>
                                @endforeach
                            </optgroup>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Contenu du message officiel</label>
                        <textarea name="contenu" class="form-control" rows="5" placeholder="Saisissez les consignes ou les informations à transmettre..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 fw-bold">Diffuser l'information</button>
                </form>
            </div>
        </div>

        <!-- HISTORIQUE ET RECEPTION DES ANNONCES (À droite) -->
        <div class="col-lg-7">
            <div class="card p-4 border-0 shadow-sm bg-white" style="max-height: 520px; overflow-y: auto;">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-history me-2"></i>Flux des communications de l'établissement</h5>
                
                @forelse($annonces as $a)
                    <div class="p-3 mb-3 rounded bg-light border-start border-4 {{ $a->cible_niveau == 'Enseignants' ? 'border-warning' : ($a->cible_niveau == 'Global' ? 'border-primary' : 'border-success') }}">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <h6 class="fw-bold text-dark mb-0">{{ $a->titre }}</h6>
                            <span class="badge bg-white text-dark border font-monospace" style="font-size: 0.65rem;">
                                Cible : {{ $a->cible_niveau ?? 'Global' }}
                            </span>
                        </div>
                        <p class="text-secondary mb-1 small" style="font-size: 0.85rem; line-height: 1.4;">{{ $a->contenu }}</p>
                        <small class="text-muted d-block text-end font-monospace" style="font-size: 0.7rem;">
                            <i class="bi bi-clock me-1"></i>Publié le {{ $a->created_at->format('d/m/Y à H:i') }}
                        </small>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-chat-square-dots" style="font-size: 2.5rem;"></i>
                        <p class="mt-2 mb-0">Aucun message partagé ou reçu pour le moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
