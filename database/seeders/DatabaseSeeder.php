<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Aula;
use App\Models\Comentario;
use App\Models\Equipo;
use App\Models\Incidencia;
use App\Models\Perfil;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Factories
        //IncidenciaSubtipo::factory(20)->create();
        Aula::factory(10)->create();
        Equipo::factory(15)->create();

        // Seeders
        $this->call([
            PersonalDepartamentoSeeder::class,
            Incidencias_subtiposSeeder::class
            //PerfilSeeder::class,
        ]);

        // Factories
        Incidencia::factory(40)->create();
        Comentario::factory(30)->create();
        Perfil::factory(25)->create();

        //Usuario para comprobar jetsTream
        $this->call(UserSeeder::class);
    }
}
