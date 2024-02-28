<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Incidencias_subtiposSeeder extends Seeder
{
    // Array de subtipos
    private array $subtipos = [
        [1, 'EQUIPOS', 'PC', 'ORDENADOR'],
        [2, 'EQUIPOS', 'PC', 'RATON'],
        [3, 'EQUIPOS', 'PC', 'TECLADO'],
        [4, 'EQUIPOS', 'ALTAVOCES', NULL],
        [5, 'EQUIPOS', 'MONITOR', NULL],
        [6, 'EQUIPOS', 'PROYECTOR', NULL],
        [7, 'EQUIPOS', 'PANTALLA', NULL],
        [8, 'EQUIPOS', 'PORTATIL', 'PROPORCIONADO POR CONSEJERIA'],
        [9, 'EQUIPOS', 'PORTATIL', 'DE AULA'],
        [10, 'EQUIPOS', 'PORTATIL', 'DE PUESTO'],
        [11, 'EQUIPOS', 'IMPRESORA', NULL],
        [12, 'CUENTAS', 'EDUCANTABRIA', NULL],
        [13, 'CUENTAS', 'GOOGLE CLASSROOM', NULL],
        [14, 'CUENTAS', 'DOMINIO', NULL],
        [15, 'CUENTAS', 'YEDRA', 'GESTIONA J.EST.'],
        [16, 'WIFI', 'IESMIGUELHERRERO', NULL],
        [17, 'WIFI', 'WIECAN', NULL],
        [18, 'INTERNET', NULL, NULL],
        [19, 'INTERNET', NULL, NULL],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->subtipos as $subtipo) {
            DB::table('incidencias_subtipos')->insert([
                'id' => $subtipo[0],
                'tipo' => $subtipo[1],
                'subtipo_nombre' => $subtipo[2],
                'sub_subtipo' => $subtipo[3],
            ]);
        }

        $this->command->info('Tabla subtipos inicializada con datos.');
    }
}
