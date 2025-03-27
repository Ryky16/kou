<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Courrier;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run()
{
    // Vérifier et insérer les rôles si nécessaire
    if (Role::count() == 0) {
        Role::insert([
            ['id' => 1, 'name' => 'Administrateur'],
            ['id' => 2, 'name' => 'Secrétaire Municipal'],
            ['id' => 3, 'name' => 'Agent'],
        ]);
    }

    // Créer les utilisateurs seulement si l'e-mail n'existe pas
    if (User::where('email', 'n.henripierre@gmail.com')->doesntExist()) {
        User::create([
            'name' => 'Admin',
            'email' => 'n.henripierre@gmail.com',
            'password' => bcrypt('password@123'),
            'role_id' => 1, // Admin
        ]);
    }

    if (User::where('email', 'secretaire@gmail.com')->doesntExist()) {
        User::create([
            'name' => 'Secrétaire Municipal',
            'email' => 'secretaire@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => 2, // Secrétaire
        ]);
    }

    if (User::where('email', 'agent@gmail.com')->doesntExist()) {
        User::create([
            'name' => 'Agent',
            'email' => 'agent@gmail.com',
            'password' => bcrypt('password'),
            'role_id' => 3, // Agent
        ]);
    }

    
    
}

}