@extends('layouts.app')

@section('title', 'Ajouter un utilisateur')

@section('content')
<section class="panel">
    <div class="panel-header"><h2>Nouvel utilisateur <i class="fa-solid fa-heart" style="color: var(--pink-500); margin-left:8px; font-size:0.9rem;"></i></h2></div>
    <form method="POST" action="{{ route('utilisateurs.store') }}">
        @include('utilisateurs._form')
    </form>
</section>
@endsection
