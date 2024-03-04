<?php

namespace Database\Factories;

use App\Models\Incidencia;
use App\Models\User;
use Exception;
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
        $incidenciasAbiertas = Incidencia::where('estado', '!=', 'CERRADA')->pluck('id')->toArray();
        $personas = User::pluck('id')->toArray();

        if (empty($incidenciasAbiertas)) {
            throw new Exception('No hay incidencias abiertas para agregar comentarios.');
        }

        $incidenciaId = $this->faker->randomElement($incidenciasAbiertas);
        $fechaCreacionIncidencia = Incidencia::find($incidenciaId)->fecha_creacion;

        $fechaComentario = $this->faker->dateTimeBetween($fechaCreacionIncidencia, 'now');

        return [
            'texto' => $this->faker->paragraph,
            'fechahora' => $fechaComentario,
            'incidencia_num' => $incidenciaId,
            'personal_id' => $this->faker->randomElement($personas),
            'adjunto_url' => null,
        ];
    }
}
