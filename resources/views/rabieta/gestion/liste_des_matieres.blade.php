@extends('Layouts.mespages')
@section('content')

<h2 class="text-center mb-5 border border-3 border-primary text-primary w-50 mx-auto p-2 rounded">Liste des Modules par Filière</h2>

<div class="d-flex justify-content-between align-items-center mb-3">
    <a class="btn btn-primary" href="/matieres/creer"><i class="bi bi-plus-lg me-2"></i>Ajouter un module</a>
    
    <form action="/matieres" method="GET" class="d-flex mb-3">
        <input type="text" name="search" class="form-control me-2" placeholder="Rechercher une matière" value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary">Rechercher</button>
        <a href="/matieres" class="btn btn-outline-secondary ms-2">Réinitialiser</a>
    </form>
</div>        

<table class="table table-striped table-hover mt-3 align-middle">
    <thead class="table-primary">
        <tr>
            <th>#</th>
            <th>Nom du module</th>
            <th>Filière affectée</th> <!-- Nouvelle colonne -->
            <th>Coefficient</th>
            <th>Gestion</th>
        </tr>
    </thead>
    <tbody>
        @foreach($toutesMatieres as $matiere)
        <tr>
            <td>{{ $matiere->id }}</td>
            <td class="fw-bold">{{ $matiere->nom_matiere }}</td>
            <td>
                <!-- Affiche la filière ou un texte par défaut si elle est vide -->
                <span class="badge bg-info text-dark p-2 fw-semibold">
                    <i class="bi bi-folder2-open me-1"></i> {{ $matiere->filiere ?? 'Général / Non spécifié' }}
                </span>
            </td>
            <td><span class="fw-bold">{{ $matiere->coefficient }}</span></td>
            <td>
                <a href="/matieres/modifier/{{ $matiere->id }}" class="btn btn-sm btn-info text-white me-1">Modifier</a>
                
                <form action="/matieres/supprimer/{{ $matiere->id }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette matière ?')">Supprimer</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
