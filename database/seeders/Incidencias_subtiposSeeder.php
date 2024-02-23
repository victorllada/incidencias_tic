<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Incidencias_subtiposSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subtipos = [
            [1, 'EQUIPOS', 'PC', 'ORDENADOR'],
            [2, 'EQUIPOS', 'PC', 'RATÓN'],
            [3, 'EQUIPOS', 'PC', 'TECLADO'],
            [4, 'EQUIPOS', 'ALTAVOCES', NULL],
            [5, 'EQUIPOS', 'MONITOR', NULL],
            [6, 'EQUIPOS', 'PROYECTOR', NULL],
            [7, 'EQUIPOS', 'PANTALLA', NULL],
            [8, 'EQUIPOS', 'PORTÁTIL', 'PROPORCIONADO POR CONSEJERÍA'],
            [9, 'EQUIPOS', 'PORTÁTIL', 'DE AULA'],
            [10, 'EQUIPOS', 'IMPRESORA', NULL],
            [11, 'CUENTAS', 'EDUCANTABRIA', NULL],
            [12, 'CUENTAS', 'GOOGLE CLASSROOM', NULL],
            [13, 'CUENTAS', 'DOMINIO', NULL],
            [14, 'CUENTAS', 'YEDRA', 'GESTIONA J.EST.'],
            [15, 'WIFI', 'iesmiguelherrero', NULL],
            [16, 'WIFI', 'WIECAN', NULL],
            [17, 'INTERNET', 'INSTALACIÓN', NULL],
            [18, 'INTERNET', 'ACTUALIZACIÓN', NULL],
        ];

        foreach ($subtipos as $subtipo) {
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
