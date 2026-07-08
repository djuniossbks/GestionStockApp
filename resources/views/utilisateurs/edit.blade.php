@extends('layouts.app')

@section('title', 'Modifier un utilisateur')

@section('content')
<section class="panel">
    <div class="panel-header"><h2>{{ $utilisateur->name }} <i class="fa-solid fa-heart" style="color: var(--pink-500); margin-left:8px; font-size:0.9rem;"></i></h2></div>
    <form method="POST" action="{{ route('utilisateurs.update', $utilisateur) }}">
        @method('PUT')
        @include('utilisateurs._form', ['utilisateur' => $utilisateur])
    </form>
</section>
@endsection
