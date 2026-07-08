<?php

namespace Database\Factories;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Produit>
 */
class ProduitFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => $this->faker->words(3, true),
            'categorie' => $this->faker->randomElement(['Informatique', 'Fournitures', 'Administration', 'Logistique']),
            'prix_unitaire' => $this->faker->randomFloat(2, 1, 500),
        ];
    }
}
