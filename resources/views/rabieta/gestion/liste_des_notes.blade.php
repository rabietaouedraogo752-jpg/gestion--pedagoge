@extends('Layouts.mespages')
@section('content')

<!-- Bloc Filtre par Niveau Scolaire -->
<div class="card mb-4 shadow-sm border-0 bg-white">
    <div class="card-body">
        <form action="{{ url('/notes') }}" method="GET" class="row g-3">
            <div class="col-md-8">
                <select name="niveau" class="form-select">
                    <option value="">-- Sélectionner un niveau d'étude --</option>
                    <option value="Licence 1" {{ request('niveau') == 'Licence 1' ? 'selected' : '' }}>Licence 1</option>
                    <option value="Licence 2" {{ request('niveau') == 'Licence 2' ? 'selected' : '' }}>Licence 2</option>
                    <option value="Licence 3" {{ request('niveau') == 'Licence 3' ? 'selected' : '' }}>Licence 3</option>
                    <option value="Master 1" {{ request('niveau') == 'Master 1' ? 'selected' : '' }}>Master 1</option>
                    <option value="Master 2" {{ request('niveau') == 'Master 2' ? 'selected' : '' }}>Master 2</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100 fw-bold">
                    <i class="bi bi-filter"></i> Appliquer le filtre
                </button>
            </div>
        </form>
    </div>
</div>

<h2 class="text-center mb-4 border border-3 border-primary text-primary w-50 mx-auto p-2 rounded fw-bold">Bulletin Général de Notes</h2>

<div class="d-flex justify-content-between align-items-center mb-3">
    <!-- Formulaire de recherche par nom -->
    <form action="/notes" method="GET" class="d-flex mb-0">
        <input type="text" name="search" class="form-control me-2" placeholder="Taper le nom de l'étudiant(e)..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary">Rechercher</button>
        @if(request('search') || request('niveau') || request('filiere'))
            <a href="/notes" class="btn btn-outline-secondary ms-2">Réinitialiser</a>
        @endif
    </form>
</div>        

<!-- 📑 NOUVELLE NAV BARRE : FILTRAGE ACADÉMIQUE PAR FILIÈRE -->
<div class="bg-white p-2 border rounded shadow-sm mb-4">
    <span class="text-muted small fw-bold d-block mb-2 ps-2"><i class="bi bi-funnel-fill text-primary"></i> Filtrer par Filière / Spécialité :</span>
    <ul class="nav nav-pills" id="filiereNav">
        <li class="nav-item">
            <a class="nav-link {{ !request('filiere') ? 'active bg-primary text-white' : 'text-secondary' }} py-1 px-3 small fw-semibold" 
               href="{{ request()->fullUrlWithQuery(['filiere' => null]) }}">
                <i class="bi bi-grid-fill me-1"></i> Toutes les filières
            </a>
        </li>
        @foreach($toutesLesFilieres ?? [] as $f)
            <li class="nav-item">
                <a class="nav-link {{ request('filiere') == $f ? 'active bg-primary text-white' : 'text-secondary' }} py-1 px-3 small fw-semibold" 
                   href="{{ request()->fullUrlWithQuery(['filiere' => $f]) }}">
                    <i class="bi bi-folder2-open me-1"></i> {{ $f }}
                </a>
            </li>
        @endforeach
    </ul>
</div>

<!-- 📦 CONTENU DYNAMIQUE SELON L'ONGLET SÉLECTIONNÉ -->
@if(!request('filiere'))
    <!-- ================= VUE : TOUTES LES FILIÈRES ================= -->
    <div class="row g-4">
        @forelse($toutesLesFilieres ?? [] as $filiereNom)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm border-0 border-top border-4 border-primary bg-white h-100">
                    <div class="card-header bg-white border-0 pt-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="bi bi-folder-fill text-warning me-2"></i>{{ $filiereNom }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6 class="text-muted small fw-bold mb-2">Modules d'enseignement :</h6>
                        <ul class="list-group list-group-flush">
                            <!-- On filtre et affiche les matières appartenant à cette filière spécifique -->
                            @forelse($matieres->where('filiere', $filiereNom) as $m)
                                <li class="list-group-item d-flex justify-content-between align-items-center ps-0 bg-transparent">
                                    <span class="small text-secondary"><i class="bi bi-book me-2"></i>{{ $m->nom_matiere }}</span>
                                    <span class="badge bg-light text-primary border font-monospace" style="font-size: 0.75rem;">Coef : {{ $m->coefficient }}</span>
                                </li>
                            @empty
                                <li class="list-group-item text-muted small ps-0 bg-transparent italic">
                                    <i class="bi bi-exclamation-circle me-1"></i> Aucun module enregistré
                                </li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer bg-light border-0 text-center py-2">
                        <a href="{{ request()->fullUrlWithQuery(['filiere' => $filiereNom]) }}" class="btn btn-sm btn-primary w-100 fw-bold">
                            <i class="bi bi-eye-fill me-1"></i> Ouvrir la saisie des notes
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light text-center py-5 shadow-sm border bg-white">
                    <i class="bi bi-folder-x text-muted" style="font-size: 2.5rem;"></i>
                    <p class="mt-2 mb-0">Aucune filière universitaire n'est configurée dans le système.</p>
                </div>
            </div>
        @endforelse
    </div>
@else
    <!-- ================= VUE : FILIÈRE SPÉCIFIQUE SÉLECTIONNÉE (TON TABLEAU ACTUEL) ================= -->
    <div class="card border-0 shadow-sm bg-white">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0 text-center">
                <thead class="table-primary">
                    <tr>
                        <th class="text-start">Étudiant</th>
                        @forelse($matieres as $ma)
                            <th>{{ $ma->nom_matiere }}</th>
                        @empty
                            <th>Aucun module pour cette filière</th>
                        @endforelse
                    </tr>
                </thead>
                <tbody>
                    @forelse($etudiants as $tu)
                    <tr>
                        <td class="fw-bold text-dark text-start">{{ $tu->nom }} {{ $tu->prenom }}</td>
                        @foreach($matieres as $ma)
                        <td>
                            @if($existe = $tu->notes->where('matiere_id', $ma->id)->first())
                                <span class="badge {{ $existe->valeur_note >= 10 ? 'bg-success' : 'bg-danger' }} p-2 d-block mb-1 font-monospace">
                                    {{ $existe->valeur_note }} / 20
                                </span>
                                 
                                <div class="d-flex gap-1 justify-content-center" style="font-size: 0.75rem;">
                                    <a href="/notes/modifier/{{ $existe->id }}" class="btn btn-sm btn-info text-white px-2 py-0"><i class="bi bi-pencil">Modifier</i></a>
                                    <form action="/notes/supprimer/{{ $existe->id }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger px-2 py-0" onclick="return confirm('Supprimer cette note ?')"><i class="bi bi-trash">Supprimer</i></button>
                                    </form>
                                </div>
                            @else
                                <a href="/notes/creer/{{ $tu->id }}/{{ $ma->id }}" class="btn btn-sm btn-outline-primary w-100 py-1">
                                    <i class="bi bi-plus-lg me-1"></i> Saisir
                                </a>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($matieres) + 1 }}" class="text-center py-4 text-muted">
                            <i class="bi bi-exclamation-triangle me-2"></i> Aucun étudiant inscrit dans cette filière.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endif
</div> 

@endsection