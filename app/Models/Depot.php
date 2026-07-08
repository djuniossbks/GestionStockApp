<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nom', 'adresse'])]
class Depot extends Model
{
    use HasFactory;

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }
}
