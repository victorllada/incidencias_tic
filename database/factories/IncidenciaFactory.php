<?php

namespace Database\Factories;

use App\Models\Equipo;
use App\Models\IncidenciaSubtipo;
use App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incidencia>
 */
class IncidenciaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subtipos = IncidenciaSubtipo::all()->pluck('tipo', 'id')->toArray();
        $personas = Personal::pluck('id')->toArray();
        $equipos = Equipo::pluck('id')->toArray();

        // Selecciona un id de subtipo aleatorio y obtiene su tipo asociado
        $randomSubtipoId = $this->faker->randomElement(array_keys($subtipos));
        $tipo = $subtipos[$randomSubtipoId];

        return [
            'tipo' => $tipo,
            'subtipo_id' => $randomSubtipoId,
            'fecha_creacion' => $this->faker->dateTime,
            'fecha_cierre' => $this->faker->optional()->dateTime,
            'duracion' => $this->faker->numberBetween(5, 600),
            'descripcion' => $this->faker->sentence,
            'actuaciones' => $this->faker->sentence,
            'estado' => $this->faker->randomElement(['abierta', 'asignada', 'en proceso', 'enviada a Infortec', 'resuelta', 'cerrada']),
            'prioridad' => $this->faker->randomElement(['baja', 'media', 'alta', 'urgente']),
            'adjunto_url' => $this->faker->optional()->url,
            'creador_id' => $this->faker->randomElement($personas),
            'responsable_id' => $this->faker->optional()->randomElement($personas),
            'equipo_id' => $this->faker->optional()->randomElement($equipos),
        ];
    }
}
