<?php

namespace Database\Factories;

use App\Models\Courrier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courrier>
 */
class CourrierFactory extends Factory
{
    protected $model = Courrier::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reference' => $this->faker->unique()->uuid,
            'expediteur' => $this->faker->name,
            'destinataire' => $this->faker->name,
            'objet' => $this->faker->sentence,
            'contenu' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['entrant', 'sortant']),
            'statut' => 'en_attente',
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
