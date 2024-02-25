<?php

namespace Database\Factories;

use App\Models\Departamento;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

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

        $departamentos = Departamento::pluck('id')->toArray();

        return [
            'name' => $this->faker->userName(),
            'nombre_completo' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            //'email_verified_at' => now(),
            'nombre_departamento' => $this->faker->randomElement(['Informática', 'Administración', 'Mecánica', 'Robótica']),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,

            'id_departamento' => $this->faker->randomElement($departamentos),
            'guid' => null,
            'domain' => null,

            'remember_token' => Str::random(10),
            //'profile_photo_path' => null,
            //'current_team_id' => null,
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

    /**
     * Indicate that the user should have a personal team.
     */
    /*public function withPersonalTeam(callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name.'\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }*/
}
