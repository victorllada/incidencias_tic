<?php

namespace Database\Factories;

use App\Models\Aula;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipo>
 */
class EquipoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $aulas = Aula::pluck('id')->toArray();

        return [
            'tipo_equipo' => $this->faker->randomElement(['altavoces', 'impresora', 'monitor', 'pantalla interactiva', 'portátil de aula', 'portátil Consejería', 'proyector']),
            'fecha_adquisicion' => $this->faker->date(),
            'etiqueta' => $this->faker->unique()->text(6),
            'marca' => $this->faker->word,
            'modelo' => $this->faker->word,
            'descripcion' => $this->faker->sentence,
            'baja' => $this->faker->boolean(),
            'aula_id' => $this->faker->randomElement($aulas),
            'puesto' => $this->faker->numberBetween(1, 30),
        ];
    }
}
