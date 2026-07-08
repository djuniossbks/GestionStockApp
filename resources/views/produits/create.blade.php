@extends('layouts.app')

@section('title', 'Ajouter un produit')

@section('content')
<section class="panel">
    <div class="panel-header"><h2>Nouveau produit <i class="fa-solid fa-heart" style="color: var(--pink-500); margin-left:8px; font-size:0.9rem;"></i> <i class="fa-solid fa-heart" style="color: var(--pink-500); margin-left:8px; font-size:0.9rem;"></i></h2></div>
    <form method="POST" action="{{ route('produits.store') }}">
        @include('produits._form')
    </form>
</section>
@endsection
