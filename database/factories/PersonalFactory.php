<?php

namespace Database\Factories;

use App\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personal>
 */
class PersonalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'dni' => $this->faker->unique()->randomNumber(9),
            'nombre' => $this->faker->firstName,
            'apellido1' => $this->faker->lastName,
            'apellido2' => $this->faker->lastName,
            'direccion' => $this->faker->address,
            'localidad' => $this->faker->text(25),
            'cp' => $this->faker->postcode,
            'tlf' => $this->faker->numberBetween(111111111, 999999999),
            'activo' => $this->faker->boolean(),
            'departamento_id' => null,
        ];
    }
}
