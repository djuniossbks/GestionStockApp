<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\LogsHistorique;
use App\Models\Produit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProduitController extends Controller
{
    use LogsHistorique;

    public function index(): View
    {
        return view('produits.index', [
            'produits' => Produit::withSum('stocks as total_stock', 'quantite')->latest()->paginate(12),
        ]);
    }

    public function create(): View
    {
        return view('produits.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:255'],
            'prix_unitaire' => ['required', 'numeric', 'min:0'],
        ]);

        $produit = Produit::create($data);
        $this->logAction($produit, 'creation_produit', 'Produit cree: '.$produit->nom);

        return redirect()->route('produits.index')->with('success', 'Produit ajoute avec succes.');
    }

    public function show(Produit $produit): View
    {
        return view('produits.show', ['produit' => $produit->load('stocks.depot')]);
    }

    public function edit(Produit $produit): View
    {
        return view('produits.edit', compact('produit'));
    }

    public function update(Request $request, Produit $produit): RedirectResponse
    {
        $data = $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'categorie' => ['required', 'string', 'max:255'],
            'prix_unitaire' => ['required', 'numeric', 'min:0'],
        ]);

        $produit->update($data);
        $this->logAction($produit, 'modification_produit', 'Produit modifie: '.$produit->nom);

        return redirect()->route('produits.index')->with('success', 'Produit modifie avec succes.');
    }

    public function destroy(Produit $produit): RedirectResponse
    {
        if (! auth()->user()->isAdmin()) {
            abort(403, 'Seul un administrateur peut supprimer un produit.');
        }

        $nom = $produit->nom;
        $this->logAction($produit, 'suppression_produit', 'Produit supprime: '.$nom);
        $produit->delete();

        return redirect()->route('produits.index')->with('success', 'Produit supprime avec succes.');
    }
}
