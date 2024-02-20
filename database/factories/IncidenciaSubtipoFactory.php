<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IncidenciaSubtipo>
 */
class IncidenciaSubtipoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tipo' => $this->faker->randomElement(['EQUIPOS', 'CUENTAS', 'WIFI', 'INTERNET', 'SOFTWARE']),
            'subtipo_nombre' => $this->faker->unique()->word,
            'sub_subtipo' => $this->faker->word,
        ];
    }
}
