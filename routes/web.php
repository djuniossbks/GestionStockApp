<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EntreeStockController;
use App\Http\Controllers\HistoriqueController;
use App\Http\Controllers\InventaireController;
use App\Http\Controllers\ParametreController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\RapportController;
use App\Http\Controllers\SortieStockController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\TransfertController;
use App\Http\Controllers\UtilisateurController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function (): void {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function (): void {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('produits', ProduitController::class);
    Route::get('entrees-stock', [EntreeStockController::class, 'index'])->name('entrees.index');
    Route::post('entrees-stock', [EntreeStockController::class, 'store'])->name('entrees.store');
    Route::get('sorties-stock', [SortieStockController::class, 'index'])->name('sorties.index');
    Route::post('sorties-stock', [SortieStockController::class, 'store'])->name('sorties.store');
    Route::get('transferts', [TransfertController::class, 'index'])->name('transferts.index');
    Route::post('transferts', [TransfertController::class, 'store'])->name('transferts.store');
    Route::get('inventaire', [InventaireController::class, 'index'])->name('inventaire.index');
    Route::get('historique', [HistoriqueController::class, 'index'])->name('historique.index');
    Route::get('rapports', [RapportController::class, 'index'])->name('rapports.index');
    Route::get('statistiques', [StatistiqueController::class, 'index'])->name('statistiques.index');
    Route::view('parametres', 'parametres.index')->name('parametres.index');

    Route::resource('utilisateurs', UtilisateurController::class)
        ->except(['show'])
        ->middleware('role:admin');
});
