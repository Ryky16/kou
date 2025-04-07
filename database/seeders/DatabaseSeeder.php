<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->seedRoles();
        $this->seedUsers();
        $this->seedServices();
        $this->seedCourriers(); // Nouvelle ligne ajoutée
        $this->seedAffectations();

    }

    protected function seedRoles()
    {
        Role::firstOrCreate(['id' => 1], ['name' => 'Administrateur']);
        Role::firstOrCreate(['id' => 2], ['name' => 'Secrétaire Municipal']);
        Role::firstOrCreate(['id' => 3], ['name' => 'Agent']);
    }

    protected function seedUsers()
    {
        User::firstOrCreate(
            ['email' => 'n.henripierre@gmail.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password@123'),
                'role_id' => 1
            ]
        );

        User::firstOrCreate(
            ['email' => 'secretaire@gmail.com'],
            [
                'name' => 'Secrétaire Municipal',
                'password' => Hash::make('password'),
                'role_id' => 2
            ]
        );

        User::firstOrCreate(
            ['email' => 'agent@gmail.com'],
            [
                'name' => 'Agent',
                'password' => Hash::make('password'),
                'role_id' => 3
            ]
        );

        // Création d'agents supplémentaires si nécessaire
        if (User::where('role_id', 3)->count() < 5) {
            User::factory()->count(5)->create(['role_id' => 3]);
        }
    }

    protected function seedServices()
    {
        $this->call(ServicesTableSeeder::class);
    }

    protected function seedCourriers()
    {
        $this->call(CourrierSeeder::class);
    }

    protected function seedAffectations()
    {
        $this->call(AffectationSeeder::class);
    }
}