<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed default production-safe users.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@exemple.com'],
            [
                'name' => 'Administrateur',
                'password' => 'password',
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'gestionnaire@exemple.com'],
            [
                'name' => 'Gestionnaire',
                'password' => 'password',
                'role' => 'gestionnaire',
            ]
        );

        User::updateOrCreate(
            ['email' => 'marie@gmail.com'],
            [
                'name' => 'Marie',
                'password' => '12345678',
                'role' => 'admin',
            ]
        );
    }
}
