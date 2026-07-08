@extends('layouts.app')

@section('title', 'Tableau de bord')

@section('content')
@php
    $stats = [
        ['icon' => 'fa-box', 'label' => 'Total Produits', 'value' => $totalProduits, 'hint' => 'Catalogue actif'],
        ['icon' => 'fa-warehouse', 'label' => 'Stock Disponible', 'value' => $stockDisponible, 'hint' => 'Toutes reserves'],
        ['icon' => 'fa-circle-plus', 'label' => "Entrees aujourd'hui", 'value' => $entreesAujourdhui, 'hint' => 'Reception du jour'],
        ['icon' => 'fa-circle-minus', 'label' => "Sorties aujourd'hui", 'value' => $sortiesAujourdhui, 'hint' => 'Expedition du jour'],
        ['icon' => 'fa-right-left', 'label' => 'Transferts en cours', 'value' => $transfertsEnCours, 'hint' => 'A surveiller'],
        ['icon' => 'fa-triangle-exclamation', 'label' => 'Stock faible', 'value' => $produitsFaibles, 'hint' => 'Seuil critique'],
    ];
@endphp

<div class="space-y-8">
    <section class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">
        <div class="px-6 py-8 sm:px-8">
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-blue-600">Pilotage du stock</p>
            <div class="mt-3 flex flex-col gap-5 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <h2 class="max-w-3xl text-3xl font-black tracking-normal text-blue-900 sm:text-4xl">Vue claire sur vos mouvements, vos reserves et vos priorites.</h2>
                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-500">Une lecture rapide des indicateurs essentiels pour garder le stock fluide, propre et pret a servir.</p>
                </div>
                <a href="{{ route('produits.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl btn btn-primary px-5 py-3 text-sm shadow-sm transition focus:outline-none">
                    <i class="fa-solid fa-plus"></i>
                    Ajouter un produit
                    <i class="fa-solid fa-heart text-white" style="margin-left:6px;opacity:.95"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="grid gap-5 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-6">
        @foreach($stats as $stat)
            <article class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:border-blue-100 hover:shadow-md">
                <div class="flex items-start justify-between gap-3">
                    <span class="grid h-12 w-12 place-items-center rounded-xl bg-blue-50 text-blue-700">
                        <i class="fa-solid {{ $stat['icon'] }}"></i>
                    </span>
                    <span class="rounded-full bg-slate-50 px-3 py-1 text-xs font-bold text-slate-500">{{ $stat['hint'] }}</span>
                </div>
                <p class="mt-5 text-sm font-bold text-slate-500">{{ $stat['label'] }} <i class="fa-solid fa-heart" style="color: var(--pink-500); margin-left:8px; font-size:0.9rem;"></i></p>
                <strong class="mt-2 block text-3xl font-black text-blue-900">{{ number_format((float) $stat['value'], 0, ',', ' ') }}</strong>
            </article>
        @endforeach
    </section>

    <section class="rounded-2xl border border-slate-100 bg-white p-5 shadow-sm sm:p-6">
        <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-[0.16em] text-blue-600">Inventaire recent</p>
                <h2 class="mt-1 text-xl font-black text-blue-900">Derniers produits</h2>
            </div>
            <a class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-bold text-blue-700 shadow-sm transition hover:border-blue-200 hover:bg-blue-50" href="{{ route('produits.index') }}">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                Voir tout
            </a>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-500">Produit</th>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-500">Categorie</th>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-500">Stock</th>
                            <th class="px-6 py-4 text-left text-xs font-black uppercase tracking-wider text-slate-500">Prix</th>
                            <th class="px-6 py-4 text-right text-xs font-black uppercase tracking-wider text-slate-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse($derniersProduits as $produit)
                            <tr class="transition hover:bg-blue-50">
                                <td class="px-6 py-5">
                                    <div class="flex items-center gap-3">
                                        <span class="grid h-10 w-10 place-items-center rounded-xl bg-blue-100 text-sm font-black text-blue-700">{{ strtoupper(substr($produit->nom, 0, 1)) }}</span>
                                        <div>
                                            <p class="font-bold text-blue-900">{{ $produit->nom }}</p>
                                            <p class="text-xs font-semibold text-slate-400">Ref #{{ str_pad((string) $produit->id, 4, '0', STR_PAD_LEFT) }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-sm font-semibold text-slate-600">{{ $produit->categorie }}</td>
                                <td class="px-6 py-5">
                                    <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-sm font-black text-blue-700">{{ (int) $produit->total_stock }}</span>
                                </td>
                                <td class="px-6 py-5 text-sm font-bold text-slate-800">{{ number_format((float) $produit->prix_unitaire, 2, ',', ' ') }}</td>
                                <td class="px-6 py-5 text-right">
                                    <a href="{{ route('produits.show', $produit) }}" class="inline-grid h-10 w-10 place-items-center rounded-xl bg-slate-100 text-slate-700 transition hover:bg-blue-600 hover:text-white" aria-label="Voir {{ $produit->nom }}">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm font-semibold text-slate-500">Aucun produit.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection
