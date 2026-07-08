<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock', function (Blueprint $table): void {
            $table->foreignId('produit_id')->constrained('produits')->cascadeOnDelete();
            $table->foreignId('depot_id')->constrained('depots')->cascadeOnDelete();
            $table->unsignedInteger('quantite')->default(0);
            $table->timestamps();
            $table->primary(['produit_id', 'depot_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};
