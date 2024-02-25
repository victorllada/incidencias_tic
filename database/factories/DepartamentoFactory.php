<?php

namespace Database\Factories;

use App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Departamento>
 */
class DepartamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cod' => $this->faker->unique()->text(6),
            'nombre' => $this->faker->unique()->word,
            'activo' => $this->faker->boolean(),
            //'jefedep_id' => null,
        ];
    }
}
