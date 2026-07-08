<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('historique', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('produit_id')->nullable()->constrained('produits')->nullOnDelete();
            $table->string('action');
            $table->foreignId('utilisateur_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historique');
    }
};
