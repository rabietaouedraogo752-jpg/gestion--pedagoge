@extends('davy.gestion.Layouts.app')
@section('title', 'Inscription')
@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0">
                    <i class="bi bi-person-plus me-2"></i>Créer un compte
                </h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="row">
                        {{-- NOM --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Nom <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nom" value="{{ old('nom') }}"
                                class="form-control @error('nom') is-invalid @enderror"
                                placeholder="Votre nom">
                            @error('nom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- PRÉNOM --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Prénom <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="prenom" value="{{ old('prenom') }}"
                                class="form-control @error('prenom') is-invalid @enderror"
                                placeholder="Votre prénom">
                            @error('prenom')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- EMAIL --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="exemple@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- RÔLE (Ajout du Chef de Département) --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Rôle <span class="text-danger">*</span>
                        </label>
                        <select name="role" id="role"
                            class="form-select @error('role') is-invalid @enderror"
                            onchange="toggleNiveau()">
                            <option value="">-- Sélectionner un rôle --</option>
                            <option value="etudiant"   {{ old('role')=='etudiant'   ? 'selected':'' }}>Étudiant</option>
                            <option value="enseignant" {{ old('role')=='enseignant' ? 'selected':'' }}>Enseignant</option>
                            <!-- NOUVEAU RÔLE ISOLÉ -->
                            <option value="chef_departement" {{ old('role')=='chef_departement' ? 'selected':'' }}>Chef de Département</option>
                            <option value="admin"      {{ old('role')=='admin'      ? 'selected':'' }}>Administrateur</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- NIVEAU D'ÉTUDE (Modifié pour masquer/afficher selon le rôle) --}}
                    <div class="mb-3" id="niveau-container" style="display:none;">
                        <label class="form-label fw-semibold">
                            Niveau d'étude
                        </label>
                        <input type="text" name="niveau"
                            value="{{ old('niveau') }}"
                            class="form-control @error('niveau') is-invalid @enderror"
                            placeholder="Ex: Licence 1, Master 2, BTS...">
                        @error('niveau')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        {{-- TÉLÉPHONE --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Téléphone</label>
                            <input type="text" name="telephone"
                                value="{{ old('telephone') }}"
                                class="form-control"
                                placeholder="+226 XX XX XX XX">
                        </div>

                        {{-- DATE DE NAISSANCE --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Date de naissance</label>
                            <input type="date" name="date_naissance"
                                value="{{ old('date_naissance') }}"
                                class="form-control">
                        </div>
                    </div>

                    {{-- ADRESSE --}}
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Adresse</label>
                        <input type="text" name="adresse"
                            value="{{ old('adresse') }}"
                            class="form-control"
                            placeholder="Votre adresse complète">
                    </div>

                    <div class="row">
                        {{-- MOT DE PASSE --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Mot de passe <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Minimum 8 caractères">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('password', 'eye1')">
                                    <i class="bi bi-eye" id="eye1"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- CONFIRMATION MOT DE PASSE --}}
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">
                                Confirmer le mot de passe <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation"
                                    id="password_confirmation"
                                    class="form-control"
                                    placeholder="Répéter le mot de passe">
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('password_confirmation', 'eye2')">
                                    <i class="bi bi-eye" id="eye2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold">S'inscrire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT JAVASCRIPT DE SÉCURITÉ ET D'AFFICHAGE DYNAMIQUE --}}
<script>
    function toggleNiveau() {
        var roleSelect = document.getElementById('role');
        var niveauContainer = document.getElementById('niveau-container');
        
        // On affiche le champ niveau d'étude SEULEMENT si l'utilisateur choisit le rôle "étudiant"
        if (roleSelect.value === 'etudiant') {
            niveauContainer.style.display = 'block';
        } else {
            niveauContainer.style.display = 'none';
        }
    }

    function togglePassword(inputId, iconId) {
        var input = document.getElementById(inputId);
        var icon = document.getElementById(iconId);
        
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("bi-eye");
            icon.classList.add("bi-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("bi-eye-slash");
            icon.classList.add("bi-eye");
        }
    }

    // Exécuter au chargement initial si l'ancienne valeur contenait une erreur
    window.onload = function() {
        toggleNiveau();
    };
</script>
@endsection
