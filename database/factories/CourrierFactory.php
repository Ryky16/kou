<?php

namespace Database\Factories;

use App\Models\Courrier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourrierFactory extends Factory
{
    protected $model = Courrier::class;

    public function definition(): array
    {
        return [
            'reference' => strtoupper($this->faker->unique()->bothify('C###')),
            'expediteur' => $this->faker->name,
            'destinataire' => $this->faker->name,
            'objet' => $this->faker->sentence,
            'contenu' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['entrant', 'sortant']),
            'statut' => $this->faker->randomElement(['en_attente', 'traité', 'archivé']),
            'user_id' => User::inRandomOrder()->first()->id ?? User::factory(),
        ];
    }
}
