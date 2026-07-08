<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Historique;
use App\Models\Produit;

trait LogsHistorique
{
    protected function logAction(?Produit $produit, string $action, string $details = ''): void
    {
        Historique::create([
            'produit_id' => $produit?->id,
            'action' => $action,
            'utilisateur_id' => auth()->id(),
            'details' => $details,
        ]);
    }
}
