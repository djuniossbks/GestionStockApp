@extends('layouts.app')

@section('title', 'Entree Stock')

@section('content')
<section class="panel mb-4">
    <div class="panel-header"><h2>Nouvelle entree <i class="fa-solid fa-heart" style="color: var(--pink-500); margin-left:8px; font-size:0.9rem;"></i> <i class="fa-solid fa-heart" style="color: var(--pink-500); margin-left:8px; font-size:0.9rem;"></i></h2></div>
    <form method="POST" action="{{ route('entrees.store') }}" class="row g-3">
        @csrf
        <div class="col-md-4"><label class="form-label">Produit</label><select name="produit_id" class="form-select" required>@foreach($produits as $produit)<option value="{{ $produit->id }}">{{ $produit->nom }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">Depot</label><select name="depot_id" class="form-select" required>@foreach($depots as $depot)<option value="{{ $depot->id }}">{{ $depot->nom }}</option>@endforeach</select></div>
        <div class="col-md-2"><label class="form-label">Quantite</label><input name="quantite" type="number" min="1" class="form-control" required></div>
        <div class="col-md-2 d-flex align-items-end"><button class="btn btn-primary w-100" type="submit"><i class="fa-solid fa-plus"></i> Ajouter <i class="fa-solid fa-heart" style="margin-left:6px;color:#fff;opacity:.95"></i></button></div>
    </form>
</section>
@include('partials.mouvements-table', ['items' => $entrees, 'type' => 'entrees'])
@endsection
