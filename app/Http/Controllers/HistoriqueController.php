<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use Illuminate\View\View;

class HistoriqueController extends Controller
{
    public function index(): View
    {
        return view('historique.index', [
            'historiques' => Historique::with(['produit', 'utilisateur'])->latest()->paginate(20),
        ]);
    }
}
