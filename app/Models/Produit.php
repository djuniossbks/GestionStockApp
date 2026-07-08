<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nom', 'categorie', 'prix_unitaire'])]
class Produit extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return ['prix_unitaire' => 'decimal:2'];
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function entrees(): HasMany
    {
        return $this->hasMany(EntreeStock::class);
    }

    public function sorties(): HasMany
    {
        return $this->hasMany(SortieStock::class);
    }

    public function transferts(): HasMany
    {
        return $this->hasMany(Transfert::class);
    }

    public function historiques(): HasMany
    {
        return $this->hasMany(Historique::class);
    }

    public function getQuantiteTotaleAttribute(): int
    {
        return (int) $this->stocks->sum('quantite');
    }
}
