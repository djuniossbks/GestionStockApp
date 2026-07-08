<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\LogsHistorique;
use App\Models\Depot;
use App\Models\Produit;
use App\Models\SortieStock;
use App\Models\Stock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SortieStockController extends Controller
{
    use LogsHistorique;

    public function index(): View
    {
        return view('sorties.index', [
            'sorties' => SortieStock::with(['produit', 'depot', 'utilisateur'])->latest()->paginate(15),
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

        try {
            DB::transaction(function () use ($data): void {
                $stock = Stock::where('produit_id', $data['produit_id'])
                    ->where('depot_id', $data['depot_id'])
                    ->lockForUpdate()
                    ->first();

                if (! $stock || $stock->quantite < $data['quantite']) {
                    abort(422, 'Stock insuffisant pour cette sortie.');
                }

                $stock->decrement('quantite', $data['quantite']);
                $sortie = SortieStock::create($data + ['utilisateur_id' => auth()->id()]);
                $this->logAction($sortie->produit, 'sortie_stock', 'Sortie de '.$data['quantite'].' unite(s).');
            });
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        return back()->with('success', 'Sortie de stock enregistree.');
    }
}
