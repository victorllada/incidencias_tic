<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AulaSeeder extends Seeder
{
    private array $plantas = [1, 2, 3];
    private int $numAulasPorPlanta = 20;

    /**
     * Run the database seeds.
     */
    public function run()
    {
        foreach ($this->plantas as $planta) {
            for ($numeroAula = 1; $numeroAula <= $this->numAulasPorPlanta; $numeroAula++) {
                $codigo = "P{$planta}A{$numeroAula}";
                $descripcion = "Aula {$numeroAula} - Planta {$planta}";

                DB::table('aulas')->insert([
                    'codigo' => $codigo,
                    'descripcion' => $descripcion,
                    'planta' => $planta,
                ]);
            }
        }

        $this->command->info('Tabla aulas inicializada con datos.');
    }
}
