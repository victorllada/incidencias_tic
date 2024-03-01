<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;

/**
 * Clase que representa la exportación de estadísticas de tipos de incidencias a un archivo.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 * Implementa la interfaz WithProperties para definir propieades al archivo.
 */
class EstadisticasTiposIncidenciasExport implements FromView, WithProperties
{
    /**
     * Aplicar propiedades al archivo generado.
     *
     * @return array Propiedades definidas.
     */
    public function properties(): array
    {
        return [
            'title' => 'Incidencias - Estadísticas'
        ];
    }

    /**
     * Obtiene la vista que representa los datos para la exportación.
     *
     * @return View La vista que contiene los datos.
     */
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

        // Devuelve la vista con los datos
        return view('exports.estadisticas_tipos_incidencias', $datos);
    }
}
