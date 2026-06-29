@extends('Layouts.mespages')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow text-center p-4 bg-white">
                <div class="card-body">
                    <div class="text-warning mb-3">
                        <i class="bi bi-hourglass-split" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-2">Compte en attente de validation</h3>
                    <p class="text-muted">
                        Bonjour <strong>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</strong>.<br>
                        Votre inscription en tant que <strong>{{ Auth::user()->role }}</strong> a bien été enregistrée. 
                        Un administrateur doit valider votre profil avant que vous ne puissiez accéder à votre tableau de bord.
                    </p>
                    <hr>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm fw-bold">
                            <i class="bi bi-box-arrow-left me-1"></i> Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
