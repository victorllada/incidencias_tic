<?php

namespace Database\Factories;

use App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Perfil>
 */
class PerfilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $personas = Personal::pluck('id')->toArray();

        return [
            'personal_id' => $this->faker->unique()->randomElement($personas),
            'dominio' => $this->faker->word,
            'educantabria' => $this->faker->word,
            'password' => $this->faker->password,
            'perfil' => $this->faker->randomElement(['administrador', 'profesor', 'otros']),
        ];
    }
}
