<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['produit_id', 'depot_id', 'quantite', 'utilisateur_id'])]
class SortieStock extends Model
{
    use HasFactory;

    protected $table = 'sortie_stock';

    public function produit(): BelongsTo { return $this->belongsTo(Produit::class); }
    public function depot(): BelongsTo { return $this->belongsTo(Depot::class); }
    public function utilisateur(): BelongsTo { return $this->belongsTo(User::class, 'utilisateur_id'); }
}
