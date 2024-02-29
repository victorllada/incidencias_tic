<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EstadisticasTiposIncidenciasExport implements FromView
{
    public function view(): View
    {
        // Número total de incidencias por tipo
        $totalPorTipo = DB::table('incidencias')
            ->select('tipo', DB::raw('count(*) as total'))
            ->groupBy('tipo')
            ->get();

        // Número de incidencias resueltas por tipo
        $resueltasPorTipo = DB::table('incidencias')
            ->select('tipo', DB::raw('count(*) as total_resueltas'))
            ->where('estado', 'RESUELTA')
            ->groupBy('tipo')
            ->get();

        // Número de incidencias abiertas por tipo
        $abiertasPorTipo = DB::table('incidencias')
            ->select('tipo', DB::raw('count(*) as total_abiertas'))
            ->where('estado', 'ABIERTA')
            ->groupBy('tipo')
            ->get();

        // Tiempo promedio de resolución por tipo
        $tiempoPromedioPorTipo = DB::table('incidencias')
            ->select('tipo', DB::raw('avg(duracion) as tiempo_promedio_resolucion'))
            ->where('estado', 'RESUELTA')
            ->groupBy('tipo')
            ->get();

        // Crear una colección con los resultados
        $datos = collect([
            'totalPorTipo' => $totalPorTipo,
            'resueltasPorTipo' => $resueltasPorTipo,
            'abiertasPorTipo' => $abiertasPorTipo,
            'tiempoPromedioPorTipo' => $tiempoPromedioPorTipo,
        ]);

        return view('exports.estadisticas_tipos_incidencias', $datos);
    }
}
