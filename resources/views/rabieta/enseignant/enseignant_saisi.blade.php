@extends('Layouts.mespages')
@section('content')

<div class="container-fluid py-4">
    <h3 class="fw-bold text-primary mb-3">
        Notes — {{ $cours->matiere->nom_matiere }} ({{ $cours->niveau }})
    </h3>


    <form method="POST" action="/enseignant/cours/{{ $cours->id }}/notes">
        @csrf
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>{{ $cours->matiere->nom_matiere }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($etudiants as $e)
                    <tr>
                        <td>{{ $e->nom }}</td>
                        <td>{{ $e->prenom }}</td>
                        <td>
                            <input
                                type="number"
                                name="notes[{{ $e->id }}]"
                                class="form-control form-control-sm"
                                min="0" max="20" step="0.25"
                                value="{{ $e->notes->first()->valeur_note ?? '' }}"
                                placeholder="—"
                            >
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            il n'y a pas d'étudiants à ce niveau.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <button type="submit" class="btn btn-primary mt-2">
            <i class="bi bi-save me-1"></i> Enregistrer les notes
        </button>
    </form>
</div>

@endsection