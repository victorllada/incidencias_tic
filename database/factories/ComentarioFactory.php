<?php

namespace Database\Factories;

use App\Models\Incidencia;
use App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comentario>
 */
class ComentarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $incidencias = Incidencia::pluck('id')->toArray();
        $personas = Personal::pluck('id')->toArray();

        return [
            'texto' => $this->faker->paragraph,
            'fechahora' => $this->faker->dateTime(),
            'incidencia_num' => $this->faker->randomElement($incidencias),
            'personal_id' => $this->faker->randomElement($personas),
            'adjunto_url' => $this->faker->optional()->imageUrl(),
        ];
    }
}
