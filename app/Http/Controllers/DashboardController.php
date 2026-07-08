<?php

namespace App\Http\Controllers;

use App\Models\EntreeStock;
use App\Models\Produit;
use App\Models\SortieStock;
use App\Models\Stock;
use App\Models\Transfert;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $produitsFaibles = Produit::withSum('stocks as total_stock', 'quantite')
            ->get()
            ->filter(fn (Produit $produit) => (int) $produit->total_stock < 5)
            ->count();

        return view('dashboard.index', [
            'totalProduits' => Produit::count(),
            'stockDisponible' => Stock::sum('quantite'),
            'entreesAujourdhui' => EntreeStock::whereDate('created_at', today())->sum('quantite'),
            'sortiesAujourdhui' => SortieStock::whereDate('created_at', today())->sum('quantite'),
            'transfertsEnCours' => Transfert::where('statut', 'en_cours')->count(),
            'produitsFaibles' => $produitsFaibles,
            'derniersProduits' => Produit::withSum('stocks as total_stock', 'quantite')->latest()->take(5)->get(),
        ]);
    }
}
