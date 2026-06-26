@extends('Layouts.mespages')
@section('content')

<div class="card p-4 shadow-sm border-0 bg-white">
    <h3 class="mb-4 text-primary fw-bold"><i class="bi bi-person-plus-fill me-2"></i>Inscrire un nouvel Étudiant</h3>

    <form action="/etudiants/envoyer" method="POST">
        @csrf

        <!-- Ligne 1 : Nom et Prénom -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="nom" class="form-label fw-bold">Nom</label>
                <input type="text" name="nom" class="form-control" placeholder="Ex: OUEDRAOGO" required>
            </div>
            <div class="col-md-6">
                <label for="prenom" class="form-label fw-bold">Prénom</label>
                <input type="text" name="prenom" class="form-control" placeholder="Ex: Rabièta" required>
            </div>
        </div>

        <!-- Ligne 2 : Département et Filière -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="departement_id" class="form-label fw-bold">Département d'affectation</label>
                <select name="departement_id" class="form-select" required>
                    <option value="">-- Choisir un département --</option>
                    @foreach($departements as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->nom_departement }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label for="filiere_choisie" class="form-label fw-bold">Filière (Spécialité)</label>
                <select name="filiere_choisie" class="form-select" required>
                    <option value="">-- Sélectionner la filière --</option>
                    @foreach($toutesLesFilieres as $filiere)
                        <option value="{{ $filiere }}">{{ $filiere }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Ligne 3 : Niveau d'étude (Année) et Téléphone -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="niveau" class="form-label fw-bold">Niveau (Année d'étude)</label>
                <select name="niveau" class="form-select" required>
                    <option value="">-- Choisir le niveau --</option>
                    <option value="Licence 1">Licence 1</option>
                    <option value="Licence 2">Licence 2</option>
                    <option value="Licence 3">Licence 3</option>
                    <option value="Master 1">Master 1</option>
                    <option value="Master 2">Master 2</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="telephone" class="form-label fw-bold">Téléphone</label>
                <input type="text" name="telephone" class="form-control" placeholder="Ex: 52895999" required>
            </div>
        </div>

        <!-- Ligne 4 : Date de naissance et Adresse -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="date_naissance" class="form-label fw-bold">Date de naissance</label>
                <input type="date" name="date_naissance" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label for="adresse" class="form-label fw-bold">Adresse de résidence</label>
                <input type="text" name="adresse" class="form-control" placeholder="Ex: Secteur 19" required>
            </div>
        </div>

        <!-- Ligne 5 : Email et Mot de passe -->
        <div class="row mb-4">
            <div class="col-md-6">
                <label for="email" class="form-label fw-bold">Adresse Email</label>
                <input type="email" name="email" class="form-control" placeholder="etudiant@ecole.bf" required>
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label fw-bold">Mot de Passe initial</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success px-4">Enregistrer l'étudiant</button> 
            <a href="/etudiants" class="btn btn-secondary px-4">Annuler</a>
        </div>
    </form>
</div>

@endsection
