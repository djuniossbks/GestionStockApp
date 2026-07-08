<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Gestion Stock') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.1.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script defer src="{{ asset('js/app.js') }}"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-900 antialiased">
<div class="app-shell min-h-screen bg-slate-50">
    @auth
        <aside class="sidebar bg-white border-r border-slate-200" id="sidebar">
            <div class="brand">
                <span class="brand-icon"><i class="fa-solid fa-boxes-stacked"></i></span>
                <span>Gestion Stock</span>
                <span class="brand-hearts" aria-hidden="true">
                    <i class="fa-solid fa-heart heart heart--delay-1"></i>
                    <i class="fa-solid fa-heart heart heart--delay-2"></i>
                    <i class="fa-regular fa-heart heart heart--delay-3"></i>
                </span>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="fa-solid fa-chart-line"></i> Tableau de bord</a>
                <a href="{{ route('produits.index') }}" class="{{ request()->routeIs('produits.*') ? 'active' : '' }}"><i class="fa-solid fa-box"></i> Produits</a>
                <a href="{{ route('entrees.index') }}" class="{{ request()->routeIs('entrees.*') ? 'active' : '' }}"><i class="fa-solid fa-circle-plus"></i> Entree Stock</a>
                <a href="{{ route('sorties.index') }}" class="{{ request()->routeIs('sorties.*') ? 'active' : '' }}"><i class="fa-solid fa-circle-minus"></i> Sortie Stock</a>
                <a href="{{ route('transferts.index') }}" class="{{ request()->routeIs('transferts.*') ? 'active' : '' }}"><i class="fa-solid fa-right-left"></i> Transfert</a>
                <a href="{{ route('inventaire.index') }}" class="{{ request()->routeIs('inventaire.*') ? 'active' : '' }}"><i class="fa-solid fa-warehouse"></i> Inventaire</a>
                <div class="sidebar-label">Suivi</div>
                <a href="{{ route('historique.index') }}" class="{{ request()->routeIs('historique.*') ? 'active' : '' }}"><i class="fa-solid fa-clock-rotate-left"></i> Historique</a>
                <a href="{{ route('rapports.index') }}" class="{{ request()->routeIs('rapports.*') ? 'active' : '' }}"><i class="fa-solid fa-file-lines"></i> Rapports</a>
                <a href="{{ route('statistiques.index') }}" class="{{ request()->routeIs('statistiques.*') ? 'active' : '' }}"><i class="fa-solid fa-chart-pie"></i> Statistiques</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('utilisateurs.index') }}" class="{{ request()->routeIs('utilisateurs.*') ? 'active' : '' }}"><i class="fa-solid fa-users-gear"></i> Utilisateurs</a>
                @endif
                <a href="{{ route('parametres.index') }}" class="{{ request()->routeIs('parametres.*') ? 'active' : '' }}"><i class="fa-solid fa-gear"></i> Parametres</a>
            </nav>
        </aside>
    @endauth

    <div class="main">
        @auth
            <header class="topbar">
                <button class="icon-button bg-blue-50 text-blue-700" id="sidebarToggle" type="button" aria-label="Ouvrir le menu"><i class="fa-solid fa-bars"></i></button>
                <div>
                    <h1 class="text-blue-900">@yield('title', 'Gestion de stock') <span style="color: #F48FB1; margin-left:8px;"><i class="fa-solid fa-heart"></i></span></h1>
                    <small class="text-slate-500">{{ auth()->user()->name }} - {{ auth()->user()->role }}</small>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="ms-auto">
                    @csrf
                    <button class="btn btn-outline-primary btn-sm" type="submit"><i class="fa-solid fa-arrow-right-from-bracket"></i> Deconnexion</button>
                </form>
            </header>
        @endauth

        <main class="content">
            @if(session('success'))
                <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger shadow-sm">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger shadow-sm">
                    <strong>Veuillez corriger les erreurs.</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>
<div class="sidebar-backdrop" id="sidebarBackdrop"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.5.1/dist/chart.umd.min.js"></script>
@stack('scripts')
</body>
</html>
