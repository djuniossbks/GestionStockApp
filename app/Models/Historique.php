<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['produit_id', 'action', 'utilisateur_id', 'details'])]
class Historique extends Model
{
    use HasFactory;

    protected $table = 'historique';

    public function produit(): BelongsTo { return $this->belongsTo(Produit::class); }
    public function utilisateur(): BelongsTo { return $this->belongsTo(User::class, 'utilisateur_id'); }
}
