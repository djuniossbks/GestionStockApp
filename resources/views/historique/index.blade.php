@extends('layouts.app')

@section('title', 'Historique')

@section('content')
<section class="panel">
    <div class="panel-header"><h2>Journal des actions <i class="fa-solid fa-heart" style="color: var(--pink-500); margin-left:8px; font-size:0.9rem;"></i></h2></div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Date</th><th>Produit</th><th>Action</th><th>Utilisateur</th><th>Details</th></tr></thead>
            <tbody>
            @forelse($historiques as $historique)
                <tr>
                    <td>{{ $historique->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $historique->produit?->nom ?? '-' }}</td>
                    <td><span class="badge text-bg-light">{{ $historique->action }}</span></td>
                    <td>{{ $historique->utilisateur?->name ?? '-' }}</td>
                    <td>{{ $historique->details }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-muted">Aucune action.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $historiques->links() }}
</section>
@endsection
