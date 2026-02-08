<?php

namespace Database\Factories;

use App\Models\Persona;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Domicilio>
 */
class DomicilioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rfc' => Persona::factory(),
            'calle' => fake()->streetName,
            'numero' => fake()->buildingNumber,
            'colonia' => fake()->streetSuffix,
            'cp' => fake()->numerify('#####'),
        ];
    }
}
