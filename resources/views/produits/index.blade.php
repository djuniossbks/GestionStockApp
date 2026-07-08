@extends('layouts.app')

@section('title', 'Produits')

@section('content')
<section class="panel">
    <div class="panel-header">
        <h2>Liste des produits <i class="fa-solid fa-heart" style="color: var(--pink-500); margin-left:8px; font-size:0.9rem;"></i></h2>
        <a class="btn btn-primary" href="{{ route('produits.create') }}"><i class="fa-solid fa-plus"></i> Ajouter</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>ID</th><th>Nom</th><th>Categorie</th><th>Quantite totale</th><th>Prix unitaire</th><th>Date creation</th><th class="text-end">Actions</th></tr></thead>
            <tbody>
            @forelse($produits as $produit)
                <tr>
                    <td>#{{ $produit->id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-heart" style="color: var(--pink-500); font-size:0.8rem;"></i>
                            {{ $produit->nom }}
                        </div>
                    </td>
                    <td>{{ $produit->categorie }}</td>
                    <td>
                        @if((int) $produit->total_stock < 5)
                            <span class="badge text-bg-warning">{{ (int) $produit->total_stock }} <i class="fa-solid fa-heart" style="color: #f59eaf; margin-left:6px;"></i></span>
                        @else
                            <span class="badge text-bg-light">{{ (int) $produit->total_stock }}</span>
                        @endif
                    </td>
                    <td>{{ number_format((float) $produit->prix_unitaire, 2, ',', ' ') }}</td>
                    <td>{{ $produit->created_at->format('d/m/Y') }}</td>
                    <td class="text-end table-actions">
                        <a class="btn btn-light btn-sm" href="{{ route('produits.show', $produit) }}"><i class="fa-solid fa-eye"></i></a>
                        <a class="btn btn-light btn-sm" href="{{ route('produits.edit', $produit) }}"><i class="fa-solid fa-pen"></i></a>
                        @if(auth()->user()->isAdmin())
                            <form method="POST" action="{{ route('produits.destroy', $produit) }}" onsubmit="return confirm('Supprimer ce produit ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm" type="submit"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted">Aucun produit.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $produits->links() }}
</section>
@endsection
