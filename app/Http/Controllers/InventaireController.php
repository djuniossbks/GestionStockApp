<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\View\View;

class InventaireController extends Controller
{
    public function index(): View
    {
        return view('inventaire.index', [
            'stocks' => Stock::with(['produit', 'depot'])
                ->join('produits', 'stock.produit_id', '=', 'produits.id')
                ->join('depots', 'stock.depot_id', '=', 'depots.id')
                ->orderBy('produits.nom')
                ->orderBy('depots.nom')
                ->select('stock.*')
                ->paginate(20),
        ]);
    }
}
