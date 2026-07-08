@extends('layouts.app')

@section('title', 'Statistiques')

@section('content')
<div class="row g-4">
    <div class="col-lg-7">
        <section class="panel h-100">
            <div class="panel-header"><h2>Entrees / Sorties mensuelles <i class="fa-solid fa-heart" style="color: var(--pink-500); margin-left:8px; font-size:0.9rem;"></i></h2></div>
            <canvas id="monthlyChart"
                data-labels='@json($moisLabels)'
                data-entrees='@json($entreesData)'
                data-sorties='@json($sortiesData)'></canvas>
        </section>
    </div>
    <div class="col-lg-5">
        <section class="panel h-100">
            <div class="panel-header"><h2>Quantites par categorie <i class="fa-solid fa-heart" style="color: var(--pink-500); margin-left:8px; font-size:0.9rem;"></i></h2></div>
            <canvas id="categoryChart"
                data-labels='@json($categorieLabels)'
                data-values='@json($categorieData)'></canvas>
        </section>
    </div>
</div>
@endsection
