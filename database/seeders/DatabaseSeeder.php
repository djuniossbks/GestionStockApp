<?php

namespace Database\Seeders;

use App\Models\Depot;
use App\Models\EntreeStock;
use App\Models\Historique;
use App\Models\Produit;
use App\Models\SortieStock;
use App\Models\Stock;
use App\Models\Transfert;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        $principal = Depot::updateOrCreate(['nom' => 'Entrepot Principal'], ['adresse' => 'Siege']);
        $secondaire = Depot::updateOrCreate(['nom' => 'Entrepot Secondaire'], ['adresse' => 'Annexe']);

        if (Depot::count() < 4) {
            Depot::factory()->count(4 - Depot::count())->create();
        }

        $depots = Depot::all();
        $produits = [
            ['nom' => 'Clavier sans fil', 'categorie' => 'Informatique', 'prix_unitaire' => 35.50, 'q1' => 12, 'q2' => 4],
            ['nom' => 'Ecran 24 pouces', 'categorie' => 'Informatique', 'prix_unitaire' => 145.00, 'q1' => 8, 'q2' => 2],
            ['nom' => 'Carton emballage', 'categorie' => 'Fournitures', 'prix_unitaire' => 1.25, 'q1' => 120, 'q2' => 45],
            ['nom' => 'Badge visiteur', 'categorie' => 'Administration', 'prix_unitaire' => 2.10, 'q1' => 3, 'q2' => 0],
            ['nom' => 'Visseuse electrique', 'categorie' => 'Outillage', 'prix_unitaire' => 58.90, 'q1' => 10, 'q2' => 5],
            ['nom' => 'Souris ergonomique', 'categorie' => 'Informatique', 'prix_unitaire' => 24.75, 'q1' => 15, 'q2' => 6],
        ];

        foreach ($produits as $item) {
            $produit = Produit::updateOrCreate(['nom' => $item['nom']], [
                'categorie' => $item['categorie'],
                'prix_unitaire' => $item['prix_unitaire'],
            ]);

            Stock::updateOrCreate(
                ['produit_id' => $produit->id, 'depot_id' => $principal->id],
                ['quantite' => $item['q1']]
            );
            Stock::updateOrCreate(
                ['produit_id' => $produit->id, 'depot_id' => $secondaire->id],
                ['quantite' => $item['q2']]
            );
        }

        if (Produit::count() < 12) {
            Produit::factory()->count(12 - Produit::count())->create()->each(function (Produit $produit) use ($depots) {
                $principal = $depots->random();
                $secondaire = $depots->where('id', '!=', $principal->id)->random();
                Stock::updateOrCreate(
                    ['produit_id' => $produit->id, 'depot_id' => $principal->id],
                    ['quantite' => rand(8, 80)]
                );
                Stock::updateOrCreate(
                    ['produit_id' => $produit->id, 'depot_id' => $secondaire->id],
                    ['quantite' => rand(0, 40)]
                );
            });
        }

        $utilisateurs = User::whereIn('role', ['admin', 'gestionnaire'])->get();
        if ($utilisateurs->count() < 4) {
            User::factory()->count(4 - $utilisateurs->count())->create();
            $utilisateurs = User::all();
        }

        $produits = Produit::all();
        $depots = Depot::all();
        $users = User::all();

        if (EntreeStock::count() < 10) {
            foreach (range(1, 10 - EntreeStock::count()) as $_) {
                $produit = $produits->random();
                $depot = $depots->random();
                EntreeStock::create([
                    'produit_id' => $produit->id,
                    'depot_id' => $depot->id,
                    'quantite' => rand(3, 25),
                    'utilisateur_id' => $users->random()->id,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
            }
        }

        if (SortieStock::count() < 10) {
            foreach (range(1, 10 - SortieStock::count()) as $_) {
                $produit = $produits->random();
                $depot = $depots->random();
                SortieStock::create([
                    'produit_id' => $produit->id,
                    'depot_id' => $depot->id,
                    'quantite' => rand(1, 20),
                    'utilisateur_id' => $users->random()->id,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
            }
        }

        if (Transfert::count() < 8) {
            foreach (range(1, 8 - Transfert::count()) as $_) {
                $depart = $depots->random();
                $destination = $depots->where('id', '!=', $depart->id)->random();
                $produit = $produits->random();
                Transfert::create([
                    'produit_id' => $produit->id,
                    'depot_depart' => $depart->id,
                    'depot_destination' => $destination->id,
                    'quantite' => rand(2, 30),
                    'statut' => collect(['en_cours', 'termine', 'annule'])->random(),
                    'utilisateur_id' => $users->random()->id,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
            }
        }

        if (Historique::count() < 20) {
            $actions = ['Entree', 'Sortie', 'Transfert', 'Ajustement', 'Produit cree'];
            foreach (range(1, 20 - Historique::count()) as $_) {
                $produit = $produits->random();
                Historique::create([
                    'produit_id' => $produit->id,
                    'action' => $actions[array_rand($actions)],
                    'utilisateur_id' => $users->random()->id,
                    'details' => 'Action effectuée sur le produit ' . $produit->nom . '.',
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
