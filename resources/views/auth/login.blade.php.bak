@extends('layouts.app')

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="brand justify-content-center mb-4">
            <span class="brand-icon"><i class="fa-solid fa-boxes-stacked"></i></span>
            <span>Gestion Stock</span>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label" for="email">Email</label>
                <input class="form-control" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label" for="password">Mot de passe</label>
                <input class="form-control" id="password" name="password" type="password" required>
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" id="remember" name="remember" type="checkbox">
                <label class="form-check-label" for="remember">Se souvenir de moi</label>
            </div>
            <button class="btn btn-primary w-100" type="submit"><i class="fa-solid fa-right-to-bracket"></i> Connexion</button>
        </form>
        <p class="text-muted small mt-3 mb-0">Compte initial : admin@exemple.com / password</p>
    </div>
</div>
@endsection
