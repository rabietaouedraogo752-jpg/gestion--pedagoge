@extends('Layouts.mespages')
@section('content')

<div class="card p-4 shadow-sm border-0">
    <h3 class="mb-4 text-primary fw-bold"><i class="bi bi-plus-circle me-2"></i>Créer un Département</h3>

    <form action="/departements/envoyer" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-bold">Nom du Département</label>
            <input type="text" name="nom_departement" class="form-control" placeholder="ex: Informatique" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Filières (Séparez par des virgules)</label>
            <input type="text" name="filieres" class="form-control" placeholder="ex: Génie Logiciel, Réseaux, RI" required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Chef de Département</label>
            <select name="chef_id" class="form-select" required>
                <option value="">-- Sélectionner un enseignant --</option>
                @foreach($enseignants as $e)
                    <option value="{{ $e->id }}">{{ $e->prenom }} {{ $e->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success px-4">Enregistrer</button> 
            <a href="/departements" class="btn btn-secondary px-4">Annuler</a>
        </div>
    </form>
</div>

@endsection
