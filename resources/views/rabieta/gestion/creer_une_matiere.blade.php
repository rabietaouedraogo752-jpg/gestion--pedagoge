@extends('Layouts.mespages')
@section('content')

<div class="card p-4 shadow-sm border-0 bg-white">
    <h3 class="mb-4 text-primary fw-bold"><i class="bi bi-journal-plus me-2"></i>Ajouter un Module à une Filière</h3>

    <form action="/matieres/envoyer" method="POST">
        @csrf

        <!-- Étape ajoutée : Sélection de la filière d'affectation -->
        <div class="mb-3">
            <label for="filiere_choisie" class="form-label fw-bold">Sélectionner la Filière Cible</label>
            <select name="filiere_choisie" class="form-select" required>
                <option value="">-- Choisir une filière du pôle --</option>
                @foreach($toutesLesFilieres as $filiere)
                    <option value="{{ $filiere }}">{{ $filiere }}</option>
                @endforeach
            </select>
            <div class="form-text text-muted">Ces filières proviennent automatiquement de la configuration de vos départements.</div>
        </div>

        <div class="mb-3">
            <label for="nom_matiere" class="form-label fw-bold">Nom du module / de la matière</label>
            <input type="text" name="nom_matiere" class="form-control" placeholder="Ex: Algorithmique avancée" required>
        </div>

        <div class="mb-3">
            <label for="coefficient" class="form-label fw-bold">Coefficient</label>
            <input type="number" name="coefficient" class="form-control" placeholder="Ex: 4" min="1" required>
        </div>

        <div class="d-flex gap-2 pt-2">
            <button type="submit" class="btn btn-success px-4">Enregistrer le module</button> 
            <a href="/matieres" class="btn btn-secondary px-4">Annuler</a>
        </div>
    </form>
</div>

@endsection
