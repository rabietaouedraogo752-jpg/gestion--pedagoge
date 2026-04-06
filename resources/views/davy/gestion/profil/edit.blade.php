@extends('Layouts.app')
@section('title', 'Modifier mon profil')
@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Modifier mon profil</h5>
                <a href="{{ route('profil.show') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Retour
                </a>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- PHOTO --}}
                    <div class="text-center mb-4">
                        <img src="{{ $user->photo_url }}" alt="Photo"
                            id="preview-photo"
                            style="width:100px;height:100px;border-radius:50%;object-fit:cover;" class="mb-2">
                        <div>
                            <label for="photo" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-camera me-1"></i>Changer la photo
                            </label>
                            <input type="file" name="photo" id="photo" class="d-none"
                                accept="image/*" onchange="previewImage(this)">
                            @error('photo') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nom *</label>
                            <input type="text" name="nom" value="{{ old('nom', $user->nom) }}"
                                class="form-control @error('nom') is-invalid @enderror">
                            @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Prénom *</label>
                            <input type="text" name="prenom" value="{{ old('prenom', $user->prenom) }}"
                                class="form-control @error('prenom') is-invalid @enderror">
                            @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="form-control @error('email') is-invalid @enderror">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Téléphone</label>
                            <input type="text" name="telephone" value="{{ old('telephone', $user->telephone) }}"
                                class="form-control" placeholder="+226 XX XX XX XX">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Date de naissance</label>
                            <input type="date" name="date_naissance"
                                value="{{ old('date_naissance', optional($user->date_naissance)->format('Y-m-d')) }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Adresse</label>
                        <input type="text" name="adresse" value="{{ old('adresse', $user->adresse) }}"
                            class="form-control" placeholder="Votre adresse complète">
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Enregistrer
                        </button>
                        <a href="{{ route('profil.show') }}" class="btn btn-secondary">
                            <i class="bi bi-x me-2"></i>Annuler
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('preview-photo').src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection