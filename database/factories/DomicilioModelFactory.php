<?php

namespace Database\Factories;

use App\Models\PersonaModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DomicilioModel>
 */
class DomicilioModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rfc' => PersonaModel::factory(),
            'calle' => fake()->streetName,
            'numero' => fake()->buildingNumber,
            'colonia' => fake()->streetSuffix,
            'cp' => fake()->numerify('#####'),
        ];
    }
}
