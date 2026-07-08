<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transferts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->cascadeOnDelete();
            $table->foreignId('depot_depart')->constrained('depots')->cascadeOnDelete();
            $table->foreignId('depot_destination')->constrained('depots')->cascadeOnDelete();
            $table->unsignedInteger('quantite');
            $table->enum('statut', ['en_cours', 'termine', 'annule'])->default('termine');
            $table->foreignId('utilisateur_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transferts');
    }
};
