<?php

namespace Database\Factories;

use App\Models\Depot;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Depot>
 */
class DepotFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => 'Depot '.$this->faker->city(),
            'adresse' => $this->faker->address(),
        ];
    }
}
