<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['produit_id', 'depot_depart', 'depot_destination', 'quantite', 'statut', 'utilisateur_id'])]
class Transfert extends Model
{
    use HasFactory;

    public function produit(): BelongsTo { return $this->belongsTo(Produit::class); }
    public function depart(): BelongsTo { return $this->belongsTo(Depot::class, 'depot_depart'); }
    public function destination(): BelongsTo { return $this->belongsTo(Depot::class, 'depot_destination'); }
    public function utilisateur(): BelongsTo { return $this->belongsTo(User::class, 'utilisateur_id'); }
}
