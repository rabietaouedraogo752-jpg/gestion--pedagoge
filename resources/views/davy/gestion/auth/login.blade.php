@extends('davy.gestion.Layouts.app')
@section('title', 'Connexion')
@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header bg-primary text-white text-center py-4">
                <i class="bi bi-mortarboard-fill" style="font-size:2.5rem;"></i>
                <h4 class="mt-2 mb-0">Gestion École</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">

                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="votre@email.com" autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Mot de passe</label>
                        <div class="input-group">
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Votre mot de passe">
                            <button class="btn btn-outline-secondary" type="button"
                                onclick="togglePassword()">
                                <i class="bi bi-eye" id="eye-icon"></i>
                            </button>
                        </div>
                        @error('password')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember">Se souvenir de moi</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center py-3 bg-light">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-primary fw-semibold">S'inscrire</a>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    function togglePassword() {
        const pwd = document.getElementById('password');
        const icon = document.getElementById('eye-icon');
        pwd.type = pwd.type === 'password' ? 'text' : 'password';
        icon.className = pwd.type === 'password' ? 'bi bi-eye' : 'bi bi-eye-slash';
    }
</script>
@endpush
@endsection