@extends('Layouts.mespages')
@section('content')

<div class="card p-4 shadow-sm border-0 bg-white mx-auto w-75">
    <h3 class="mb-4 text-primary fw-bold">
        <i class="bi bi-pencil-square me-2"></i>Modifier le Département : {{ $departement->nom_departement }}
    </h3>

    <!-- L'action pointe vers la route PUT de mise à jour avec l'ID du département -->
    <form action="/departements/modifier/{{ $departement->id }}" method="POST">
        @csrf
        @method('PUT') <!-- Obligatoire pour les requêtes de modification sous Laravel -->

        <!-- Champ 1 : Nom du Département -->
        <div class="mb-3">
            <label for="nom_departement" class="form-label fw-bold">Nom du Département</label>
            <input type="text" name="nom_departement" class="form-control" 
                   value="{{ old('nom_departement', $departement->nom_departement) }}" 
                   placeholder="ex: Informatique" required>
        </div>

        <!-- Champ 2 : Les filières textuelles -->
        <div class="mb-3">
            <label for="filieres" class="form-label fw-bold">Filières rattachées (Séparez par des virgules)</label>
            <input type="text" name="filieres" class="form-control" 
                   value="{{ old('filieres', $departement->filieres) }}" 
                   placeholder="ex: Génie Logiciel, Réseaux, RI" required>
            <div class="form-text text-muted">Exemple : Génie Logiciel, Cybersécurité, Data Science</div>
        </div>

        <!-- Champ 3 : Sélection du Chef de Département -->
        <div class="mb-4">
            <label for="chef_id" class="form-label fw-bold">Chef de Département (Direction)</label>
            <select name="chef_id" class="form-select" required>
                <option value="">-- Sélectionner un profil Direction --</option>
                @foreach($enseignants as $e)
                    <!-- Sélection automatique du chef actuel grâce à la condition Ternaire old() / == -->
                    <option value="{{ $e->id }}" {{ old('chef_id', $departement->chef_id) == $e->id ? 'selected' : '' }}>
                        {{ $e->prenom }} {{ $e->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Boutons d'actions -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success px-4 fw-bold">Enregistrer les modifications</button> 
            <a href="/departements" class="btn btn-secondary px-4">Annuler</a>
        </div>
    </form>
</div>

@endsection
