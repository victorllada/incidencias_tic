<?php

namespace Database\Factories;

use App\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $departamentoFactory = new DepartamentoFactory();

        $nombreDepartamento = $this->faker->randomElement($departamentoFactory->getDepartamentos());
        $departamento = Departamento::where('nombre', $nombreDepartamento)->first();

        return [
            'name' => $this->faker->unique()->username(),
            'nombre_completo' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail,
            'password' => bcrypt('1234'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'id_departamento' => $departamento->id,
            'guid' => null,
            'domain' => 'iesmhp',
            'nombre_departamento' => $nombreDepartamento,
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

}
