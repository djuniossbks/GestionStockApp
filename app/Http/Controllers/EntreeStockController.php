<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\LogsHistorique;
use App\Models\Depot;
use App\Models\EntreeStock;
use App\Models\Produit;
use App\Models\Stock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EntreeStockController extends Controller
{
    use LogsHistorique;

    public function index(): View
    {
        return view('entrees.index', [
            'entrees' => EntreeStock::with(['produit', 'depot', 'utilisateur'])->latest()->paginate(15),
            'produits' => Produit::orderBy('nom')->get(),
            'depots' => Depot::orderBy('nom')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'produit_id' => ['required', 'exists:produits,id'],
            'depot_id' => ['required', 'exists:depots,id'],
            'quantite' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($data): void {
            $stock = Stock::firstOrCreate(
                ['produit_id' => $data['produit_id'], 'depot_id' => $data['depot_id']],
                ['quantite' => 0]
            );
            $stock->increment('quantite', $data['quantite']);

            $entree = EntreeStock::create($data + ['utilisateur_id' => auth()->id()]);
            $this->logAction($entree->produit, 'entree_stock', 'Entree de '.$data['quantite'].' unite(s).');
        });

        return back()->with('success', 'Entree de stock enregistree.');
    }
}
