<?php

namespace Database\Seeders;

use App\Models\Affectation;
use Illuminate\Database\Seeder;

class AffectationSeeder extends Seeder
{
    public function run(): void
    {
        Affectation::create([
            'courrier_id' => 1,
            'user_id' => 2,
            'statut' => 'non_lu',
        ]);
    }
}
