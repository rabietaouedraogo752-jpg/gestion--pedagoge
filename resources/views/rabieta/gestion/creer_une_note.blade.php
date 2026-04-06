@extends('Layouts.mespages')
@section('content')
<form action="/notes/envoyer" method="POST" class="card p-4 shadow-sm">
    @csrf
    
    <input type="hidden" name="user_id" value="{{ $user_id}}">
    <input type="hidden" name="matiere_id" value="{{ $matiere_id}}">
    <div class="mb-3">
        <label class="form-label">Note</label>
        <input type="number" name="valeur_note" class="form-control" >
    </div>
    <button type="submit" class="btn btn-success mb-3">Enregistrer la note</button> 
    <a href="/etudiants" class="btn btn-secondary">Annuler</a>
</form>
@endsection