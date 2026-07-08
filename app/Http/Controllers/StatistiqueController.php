<?php

namespace App\Http\Controllers;

use App\Models\EntreeStock;
use App\Models\Produit;
use App\Models\SortieStock;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StatistiqueController extends Controller
{
    public function index(): View
    {
        $entrees = EntreeStock::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mois, SUM(quantite) as total")
            ->groupBy('mois')->orderBy('mois')->pluck('total', 'mois');
        $sorties = SortieStock::selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mois, SUM(quantite) as total")
            ->groupBy('mois')->orderBy('mois')->pluck('total', 'mois');

        $mois = $entrees->keys()->merge($sorties->keys())->unique()->values();

        $categories = Produit::query()
            ->leftJoin('stock', 'produits.id', '=', 'stock.produit_id')
            ->select('categorie', DB::raw('COALESCE(SUM(stock.quantite), 0) as total'))
            ->groupBy('categorie')
            ->orderBy('categorie')
            ->get();

        return view('statistiques.index', [
            'moisLabels' => $mois,
            'entreesData' => $mois->map(fn ($moisKey) => (int) ($entrees[$moisKey] ?? 0)),
            'sortiesData' => $mois->map(fn ($moisKey) => (int) ($sorties[$moisKey] ?? 0)),
            'categorieLabels' => $categories->pluck('categorie'),
            'categorieData' => $categories->pluck('total')->map(fn ($value) => (int) $value),
        ]);
    }
}
