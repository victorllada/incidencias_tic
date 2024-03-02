<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipo>
 */
class EquipoFactory extends Factory
{
    private array $marcas = ['Dell', 'HP', 'Lenovo', 'Acer', 'Asus', 'Apple', 'Logitech', 'MSI'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $marca = $this->faker->randomElement($this->marcas);
        $codigoModelo = $this->faker->regexify('[A-Za-z0-9]{6}');

        return [
            'tipo_equipo' => $this->faker->randomElement(['altavoces', 'impresora', 'monitor', 'pantalla interactiva', 'portátil de aula', 'portátil Consejería', 'proyector']),
            'fecha_adquisicion' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            //'etiqueta' => ,
            'marca' => $marca,
            'modelo' => "{$marca} {$codigoModelo}",
            'descripcion' => $this->faker->sentence,
            'baja' => $this->faker->boolean(),
            //'aula_id' => ,
            //'puesto' => ,
            'puesto' => $this->faker->numberBetween(1, 30),
        ];
    }
}
