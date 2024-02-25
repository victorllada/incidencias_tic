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
        Departamento::factory(10)->create();

        //Seeder de user (para comprobar jetsTream)
        $this->call(UserSeeder::class);
    }
}
