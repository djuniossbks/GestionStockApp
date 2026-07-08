<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['produit_id', 'depot_id', 'quantite'])]
class Stock extends Model
{
    protected $table = 'stock';
    public $incrementing = false;
    protected $primaryKey = null;

    protected function setKeysForSaveQuery($query): Builder
    {
        return $query
            ->where('produit_id', $this->getAttribute('produit_id'))
            ->where('depot_id', $this->getAttribute('depot_id'));
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class);
    }

    public function depot(): BelongsTo
    {
        return $this->belongsTo(Depot::class);
    }
}
