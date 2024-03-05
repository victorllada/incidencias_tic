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
        [12, 'EQUIPOS', 'PANTALLA INTERACTIVA', NULL],
        [13, 'CUENTAS', 'EDUCANTABRIA', NULL],
        [14, 'CUENTAS', 'GOOGLE CLASSROOM', NULL],
        [15, 'CUENTAS', 'DOMINIO', NULL],
        [16, 'CUENTAS', 'YEDRA', NULL],
        [17, 'WIFI', 'IESMIGUELHERRERO', NULL],
        [18, 'WIFI', 'WIECAN', NULL],
        [19, 'SOFTWARE', 'ACTUALIZACION', NULL],
        [20, 'SOFTWARE', 'INSTALACION', NULL],
        [21, 'INTERNET', NULL, NULL],
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
