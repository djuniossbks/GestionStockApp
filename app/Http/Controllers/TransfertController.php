<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\LogsHistorique;
use App\Models\Depot;
use App\Models\Produit;
use App\Models\Stock;
use App\Models\Transfert;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TransfertController extends Controller
{
    use LogsHistorique;

    public function index(): View
    {
        return view('transferts.index', [
            'transferts' => Transfert::with(['produit', 'depart', 'destination', 'utilisateur'])->latest()->paginate(15),
            'produits' => Produit::orderBy('nom')->get(),
            'depots' => Depot::orderBy('nom')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'produit_id' => ['required', 'exists:produits,id'],
            'depot_depart' => ['required', 'exists:depots,id', 'different:depot_destination'],
            'depot_destination' => ['required', 'exists:depots,id'],
            'quantite' => ['required', 'integer', 'min:1'],
        ]);

        try {
            DB::transaction(function () use ($data): void {
                $depart = Stock::where('produit_id', $data['produit_id'])
                    ->where('depot_id', $data['depot_depart'])
                    ->lockForUpdate()
                    ->first();

                if (! $depart || $depart->quantite < $data['quantite']) {
                    abort(422, 'Stock insuffisant dans le depot de depart.');
                }

                $depart->decrement('quantite', $data['quantite']);
                $destination = Stock::firstOrCreate(
                    ['produit_id' => $data['produit_id'], 'depot_id' => $data['depot_destination']],
                    ['quantite' => 0]
                );
                $destination->increment('quantite', $data['quantite']);

                $transfert = Transfert::create($data + ['statut' => 'termine', 'utilisateur_id' => auth()->id()]);
                $this->logAction($transfert->produit, 'transfert_stock', 'Transfert de '.$data['quantite'].' unite(s).');
            });
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        return back()->with('success', 'Transfert effectue avec succes.');
    }
}
