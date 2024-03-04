<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Aula;
use App\Models\Comentario;
use App\Models\Departamento;
use App\Models\Equipo;
use App\Models\Incidencia;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seeder de roles
        $this->call(RolesSeeder::class);

        // Seeder de aulas
        $this->call(AulaSeeder::class);

        // Factory de equipos para las aulas
        $this->command->info('Inicializando con datos tabla equipos...');
        $this->generarEquiposParaAulas();
        $this->command->info('Tabla equipos inicializada con datos.');

        // Factory de departamentos
        $this->command->info('Inicializando con datos tabla departamentos...');
        Departamento::factory(15)->create();
        $this->command->info('Tabla departamentos inicializada con datos.');

        // Seeder de incidencias subtipos
        $this->call(Incidencias_subtiposSeeder::class);

        // Factory de usuarios
        $this->command->info('Inicializando con datos tabla users...');
        User::factory(40)->create();
        $this->command->info('Tabla users inicializada con datos.');

        // Factory de incidencias
        $this->command->info('Inicializando con datos tabla incidencias...');
        Incidencia::factory(200)->create();
        $this->command->info('Tabla incidencias inicializada con datos.');

        //Factory de comentarios
        $this->command->info('Inicializando con datos tabla comentarios...');
        Comentario::factory(30)->create();
        $this->command->info('Tabla comentarios inicializada con datos.');

        // Desarrollo inicial
        /*
        // Seeder de roles
        $this->call(RolesSeeder::class);

        // Factories de aula, equipo y Users
        Aula::factory(10)->create();
        Equipo::factory(15)->create();
        User::factory(10)->create();

        //Seeder de incidencias subtipos
        $this->call([
            Incidencias_subtiposSeeder::class
        ]);

        //Factories Incidencias, comentarios y departamentos
        Incidencia::factory(40)->create();
        Comentario::factory(30)->create();
        Departamento::factory(4)->create();

        //Seeder de user (para comprobar jetsTream)
        $this->call(UserSeeder::class);
        */
    }

    /**
     * Genera equipos para cada aula.
     */
    private function generarEquiposParaAulas(): void
    {
        $aulas = Aula::all();
        $maxEquiposPorAula = 30;

        foreach ($aulas as $aula) {
            $numeroEquipos = rand(10, $maxEquiposPorAula);
            $equipos = Equipo::factory($numeroEquipos)->make();

            foreach ($equipos as $equipo) {
                $equipo->aula_id = $aula->id;
                $equipo->etiqueta = "{$aula->codigo}-{$equipo->puesto}";
                $equipo->save();
            }
        }
    }
}
