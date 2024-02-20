<?php

namespace Database\Seeders;

use App\Models\Personal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datosPerfiles = [
            ['personal_id' => Personal::inRandomOrder()->first()->id, 'dominio' => 'dominio1', 'educantabria' => 'educantabria1', 'password' => 'password1', 'perfil' => 'administrador'],
            ['personal_id' => Personal::inRandomOrder()->first()->id, 'dominio' => 'dominio2', 'educantabria' => 'educantabria2', 'password' => 'password2', 'perfil' => 'profesor'],
        ];

        DB::table('perfiles')->insert($datosPerfiles);

        $this->command->info('Tabla perfiles inicializada con datos.');
    }
}
