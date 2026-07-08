<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use App\Models\Produit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RapportController extends Controller
{
    public function index(Request $request): View|Response
    {
        $query = Historique::with(['produit', 'utilisateur'])->latest();

        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date('date_debut'));
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date('date_fin'));
        }
        if ($request->filled('produit_id')) {
            $query->where('produit_id', $request->integer('produit_id'));
        }
        if ($request->filled('utilisateur_id')) {
            $query->where('utilisateur_id', $request->integer('utilisateur_id'));
        }
        if ($request->filled('action')) {
            $query->where('action', $request->string('action'));
        }

        if ($request->boolean('export')) {
            $rows = $query->get();
            $csv = "Date,Produit,Action,Utilisateur,Details\n";
            foreach ($rows as $row) {
                $csv .= sprintf(
                    "\"%s\",\"%s\",\"%s\",\"%s\",\"%s\"\n",
                    $row->created_at?->format('Y-m-d H:i'),
                    $row->produit?->nom ?? '-',
                    $row->action,
                    $row->utilisateur?->name ?? '-',
                    str_replace('"', '""', (string) $row->details)
                );
            }

            return response($csv, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="rapport-stock.csv"',
            ]);
        }

        return view('rapports.index', [
            'rapports' => $query->paginate(20)->withQueryString(),
            'produits' => Produit::orderBy('nom')->get(),
            'utilisateurs' => User::orderBy('name')->get(),
            'actions' => Historique::select('action')->distinct()->orderBy('action')->pluck('action'),
        ]);
    }
}
