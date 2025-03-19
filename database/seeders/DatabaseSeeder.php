<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Vérifie si l'utilisateur existe avant de l'insérer
        User::firstOrCreate(
            ['email' => 'test@example.com'], // Condition de recherche
            [
                'name' => 'Test User',
                'password' => bcrypt('password'), // Ajoute un mot de passe si nécessaire
            ]
        );

       
    }
}
