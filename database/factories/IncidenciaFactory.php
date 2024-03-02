<?php

namespace Database\Factories;

use App\Models\Equipo;
use App\Models\IncidenciaSubtipo;
use App\Models\User;
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
        $personas = User::pluck('id')->toArray();
        $administrador = User::role('administrador')->first();
        $equipos = Equipo::pluck('id')->toArray();

        $randomSubtipoId = $this->faker->randomElement(array_keys($subtipos));
        $tipo = $subtipos[$randomSubtipoId];

        $fechaCreacion = $this->faker->dateTimeBetween('-5 years', 'now');

        $estado = $this->faker->randomElement(['ABIERTA', 'ASIGNADA', 'EN PROCESO', 'ENVIADA A INFORTEC', 'RESUELTA', 'CERRADA']);

        if ($estado === 'CERRADA') {
            $fechaCierre = $this->faker->dateTimeBetween($fechaCreacion, 'now');
        } else {
            $fechaCierre = null;
        }

        $equipoId = ($tipo === 'EQUIPOS') ? $this->faker->randomElement($equipos) : null;

        return [
            'tipo' => $tipo,
            'subtipo_id' => $randomSubtipoId,
            'fecha_creacion' => $fechaCreacion,
            'fecha_cierre' => $fechaCierre,
            'duracion' => $this->faker->numberBetween(1, 10080),
            'descripcion' => $this->faker->sentence,
            'actuaciones' => $this->faker->sentence,
            'estado' => $estado,
            'prioridad' => $this->faker->randomElement(['BAJA', 'MEDIA', 'ALTA', 'URGENTE']),
            'adjunto_url' => null,
            'creador_id' => $this->faker->randomElement($personas),
            'responsable_id' => $administrador->id,
            'equipo_id' => $equipoId,
        ];
    }
}
