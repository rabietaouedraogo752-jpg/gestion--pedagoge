@extends('Layouts.mespages')
@section('content')
<form action="/notes/modifier/{{ $note->id}}" method="POST" class="card p-4 shadow-sm">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label  class="form-label">Etudiant(e)</label>
        <input type="text"  value="{{ $note->user->name }}" class="form-control" readonly>
    </div>
    
    <div class="mb-3">
        <label class="form-label">Matière</label>
        <input type="text" class="form-control" value="{{ $note->matiere->nom_matiere }}" readonly>
    </div>

    <div class="mb-3">
        <label for="valeur_note" class="form-label">Note</label>
        <input type="number" name="valeur_note" class="form-control" value="{{ $note->valeur_note}}" required>
    </div>
    <button type="submit" class="btn btn-success mb-3">Mettre à jour</button> 
    <a href="/notes" class="btn btn-secondary">Annuler</a>
</form>
@endsection