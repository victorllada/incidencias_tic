<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;

/**
 * Clase que representa la exportación de estadísticas de incidencias a un archivo.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 * Implementa la interfaz WithProperties para definir propieades al archivo.
 * Implementa la interfaz ShouldAutoSize para auto ajustar el tamaño de la tabla.
 */
class EstadisticasTiposIncidenciasExport implements FromView, WithProperties, ShouldAutoSize
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
        $totalPorTipo = $this->obtenerEstadisticasIncidenciasTotalPorTipo();
        $resueltasPorTipo = $this->obtenerEstadisticasIncidenciasResueltasPorTipo();
        $abiertasPorTipo = $this->obtenerEstadisticasIncidenciasAbiertasPorTipo();
        $cerradasPorTipo = $this->obtenerEstadisticasIncidenciasCerradasPorTipo();
        $asignadasPorTipo = $this->obtenerEstadisticasIncidenciasAsignadasPorTipo();
        $enProcesoPorTipo = $this->obtenerEstadisticasIncidenciasEnProcesoPorTipo();
        $enviadaAInfortecPorTipo = $this->obtenerEstadisticasIncidenciasEnviadaAInfortecPorTipo();
        $conteoPorEstadoYTipo = $this->obtenerEstadisticasIncidenciasPorEstadoYTipo();
        $incidenciasPorDepartamento = $this->obtenerEstadisticasIncidenciasPorDepartamento();
        $tiempoPromedioPorTipo = $this->obtenerEstadisticasIncidenciasTiempoPromedioPorTipo();
        $conteoPorEstadoYResponsable = $this->obtenerEstadisticasIncidenciasPorEstadoYResponsable();

        // Colección con los resultados
        $datos = collect([
            'totalPorTipo' => $totalPorTipo,
            'resueltasPorTipo' => $resueltasPorTipo,
            'abiertasPorTipo' => $abiertasPorTipo,
            'cerradasPorTipo' => $cerradasPorTipo,
            'asignadasPorTipo' => $asignadasPorTipo,
            'enProcesoPorTipo' => $enProcesoPorTipo,
            'enviadaAInfortecPorTipo' => $enviadaAInfortecPorTipo,
            'conteoPorEstadoYTipo' => $conteoPorEstadoYTipo,
            'incidenciasPorDepartamento' => $incidenciasPorDepartamento,
            'tiempoPromedioPorTipo' => $tiempoPromedioPorTipo,
            'conteoPorEstadoYResponsable' => $conteoPorEstadoYResponsable,
        ]);

        // Devuelve la vista con los datos de la colección
        return view('exports.estadisticas_tipos_incidencias', $datos);
    }

    /**
     * Obtiene el número total de incidencias por tipo.
     *
     * @return \Illuminate\Support\Collection
     */
    private function obtenerEstadisticasIncidenciasTotalPorTipo()
    {
        $totalPorTipo = DB::table('incidencias')
            ->select('tipo', DB::raw('count(*) as total'))
            ->groupBy('tipo')
            ->get();

        return $totalPorTipo;
    }

    /**
     * Obtiene el número de incidencias resueltas por tipo.
     *
     * @return \Illuminate\Support\Collection
     */
    private function obtenerEstadisticasIncidenciasResueltasPorTipo()
    {
        $resueltasPorTipo = DB::table('incidencias')
            ->select('tipo', DB::raw('count(*) as total_resueltas'))
            ->where('estado', 'RESUELTA')
            ->groupBy('tipo')
            ->get();

        return $resueltasPorTipo;
    }

    /**
     * Obtiene el número de incidencias abiertas por tipo.
     *
     * @return \Illuminate\Support\Collection
     */
    private function obtenerEstadisticasIncidenciasAbiertasPorTipo()
    {
        $abiertasPorTipo = DB::table('incidencias')
            ->select('tipo', DB::raw('count(*) as total_abiertas'))
            ->where('estado', 'ABIERTA')
            ->groupBy('tipo')
            ->get();

        return $abiertasPorTipo;
    }

    /**
     * Obtiene el número de incidencias cerradas por tipo.
     *
     * @return \Illuminate\Support\Collection
     */
    private function obtenerEstadisticasIncidenciasCerradasPorTipo()
    {
        $cerradasPorTipo = DB::table('incidencias')
            ->select('tipo', DB::raw('count(*) as total_cerradas'))
            ->where('estado', 'CERRADA')
            ->groupBy('tipo')
            ->get();

        return $cerradasPorTipo;
    }

    /**
     * Obtiene el número de incidencias asignadas por tipo.
     *
     * @return \Illuminate\Support\Collection
     */
    private function obtenerEstadisticasIncidenciasAsignadasPorTipo()
    {
        $asignadasPorTipo = DB::table('incidencias')
            ->select('tipo', DB::raw('count(*) as total_asignadas'))
            ->where('estado', 'ASIGNADA')
            ->groupBy('tipo')
            ->get();

        return $asignadasPorTipo;
    }

    /**
     * Obtiene el número de incidencias en proceso por tipo.
     *
     * @return \Illuminate\Support\Collection
     */
    private function obtenerEstadisticasIncidenciasEnProcesoPorTipo()
    {
        $enProcesoPorTipo = DB::table('incidencias')
            ->select('tipo', DB::raw('count(*) as total_enProceso'))
            ->where('estado', 'EN PROCESO')
            ->groupBy('tipo')
            ->get();

        return $enProcesoPorTipo;
    }

    /**
     * Obtiene el número de incidencias enviadas a INFORTEC por tipo.
     *
     * @return \Illuminate\Support\Collection
     */
    private function obtenerEstadisticasIncidenciasEnviadaAInfortecPorTipo()
    {
        $enviadaAInfortecPorTipo = DB::table('incidencias')
            ->select('tipo', DB::raw('count(*) as total_enviadaAInfortec'))
            ->where('estado', 'ENVIADA A INFORTEC')
            ->groupBy('tipo')
            ->get();

        return $enviadaAInfortecPorTipo;
    }

    /**
     * Obtiene el conteo de incidencias por estado y tipo.
     *
     * @return \Illuminate\Support\Collection
     */
    private function obtenerEstadisticasIncidenciasPorEstadoYTipo()
    {
        $conteoPorEstadoYTipo = DB::table('incidencias')
            ->select('tipo', 'estado', DB::raw('count(*) as total'))
            ->groupBy('tipo', 'estado')
            ->get();

        return $conteoPorEstadoYTipo;
    }

    /**
     * Obtiene el tiempo promedio de resolución por tipo.
     *
     * @return \Illuminate\Support\Collection
     */
    private function obtenerEstadisticasIncidenciasTiempoPromedioPorTipo()
    {
        $tiempoPromedioPorTipo = DB::table('incidencias')
            ->select('tipo', DB::raw('avg(duracion) as tiempo_promedio_resolucion'))
            ->where('estado', 'RESUELTA')
            ->groupBy('tipo')
            ->get();

        return $tiempoPromedioPorTipo;
    }

    /**
     * Obtiene el número de incidencias por estado y el nombre del responsable.
     *
     * @return \Illuminate\Support\Collection
     */
    private function obtenerEstadisticasIncidenciasPorEstadoYResponsable()
    {
        $conteoPorEstadoYResponsable = DB::table('incidencias')
            ->join('users', 'users.id', '=', 'incidencias.responsable_id')
            ->select('users.nombre_completo as responsable_nombre', 'incidencias.estado', DB::raw('count(*) as total'))
            ->groupBy('users.nombre_completo', 'incidencias.estado')
            ->get();

        return $conteoPorEstadoYResponsable;
    }

    /**
     * Obtiene el número de incidencias por departamento.
     *
     * @return \Illuminate\Support\Collection
     */
    private function obtenerEstadisticasIncidenciasPorDepartamento()
    {
        $incidenciasPorDepartamento = DB::table('departamentos')
            ->leftJoin('users', 'departamentos.id', '=', 'users.id_departamento')
            ->leftJoin('incidencias', 'users.id', '=', 'incidencias.responsable_id')
            ->select('departamentos.nombre as departamento', DB::raw('count(incidencias.id) as total_incidencias'))
            ->groupBy('departamentos.nombre')
            ->get();

        return $incidenciasPorDepartamento;
    }
}
