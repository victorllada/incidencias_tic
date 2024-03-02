<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Departamento>
 */
class DepartamentoFactory extends Factory
{
    private array $departamentos = [
        'Informática',
        'Administración',
        'Mecánica',
        'Robótica',
        'Electrónica',
        'Electricidad',
        'Automoción',
        'Física',
        'Química',
        'Biología',
        'Historia',
        'Educación Física',
        'Arte',
        'Música',
        'Matemáticas',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nombreDepartamento = $this->departamentos[$this->faker->unique()->numberBetween(0, count($this->departamentos) - 1)];
        $codigo = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', substr(str_replace(['á','é','í','ó','ú','Á','É','Í','Ó','Ú'], ['a','e','i','o','u','A','E','I','O','U'], $nombreDepartamento), 0, 3))) . '01';

        return [
            'cod' => $codigo,
            'nombre' => $nombreDepartamento,
            'activo' => $this->faker->boolean(),
        ];
    }

    /**
     * Devuelve un array con los departamentos disponibles.
     *
     * @return array Departamentos disponibles.
     */
    public function getDepartamentos() : array {
        return $this->departamentos;
    }
}
