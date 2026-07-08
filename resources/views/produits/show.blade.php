@extends('layouts.app')

@section('title', 'Consulter un produit')

@section('content')
<section class="panel">
    <div class="panel-header">
        <h2>{{ $produit->nom }} <i class="fa-solid fa-heart" style="color: var(--pink-500); margin-left:8px; font-size:0.9rem;"></i></h2>
        <a href="{{ route('produits.edit', $produit) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen"></i> Modifier <i class="fa-solid fa-heart" style="margin-left:6px;color:#fff;font-size:0.7rem;opacity:.95"></i></a>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-3"><div class="mini-info"><span>ID</span><strong>#{{ $produit->id }}</strong></div></div>
        <div class="col-md-3"><div class="mini-info"><span>Categorie</span><strong>{{ $produit->categorie }}</strong></div></div>
        <div class="col-md-3"><div class="mini-info"><span>Prix</span><strong>{{ number_format((float) $produit->prix_unitaire, 2, ',', ' ') }}</strong></div></div>
        <div class="col-md-3"><div class="mini-info"><span>Creation</span><strong>{{ $produit->created_at->format('d/m/Y') }}</strong></div></div>
    </div>
    <h3 class="section-title">Stock par depot</h3>
    <div class="table-responsive">
        <table class="table">
            <thead><tr><th>Depot</th><th>Adresse</th><th>Quantite</th></tr></thead>
            <tbody>
            @forelse($produit->stocks as $stock)
                <tr><td>{{ $stock->depot->nom }}</td><td>{{ $stock->depot->adresse }}</td><td>{{ $stock->quantite }}</td></tr>
            @empty
                <tr><td colspan="3" class="text-center text-muted">Aucun stock.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
