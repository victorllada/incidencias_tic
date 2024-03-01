<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;

/**
 * Clase que representa una exportación de incidencias resueltas con tiempos por tipo para su visualización en una vista.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 * Implementa la interfaz ShouldAutoSize para auto ajustar el tamaño de la tabla.
 * Implementa la interfaz WithProperties para definir propieades al archivo.
 */
class IncidenciasResueltasTiempoPorTipoExport implements FromView, ShouldAutoSize, WithProperties
{
    /**
     * Aplicar propiedades al archivo generado.
     *
     * @return array Propiedades definidas.
     */
    public function properties(): array
    {
        return [
            'title' => 'Incidencias - Resueltas'
        ];
    }

    /**
     * Obtiene la vista que representa la exportación de incidencias resueltas con tiempos por tipo.
     *
     * @return View La vista que contiene la información de los tiempos de resolución por tipo de incidencia.
     */
    public function view(): View
    {
        $usuariosConIncidenciasResueltasOCerradas = User::role('administrador')
            ->whereHas('incidenciasResueltasOcerradas')
            ->get();

        $tiposIncidenciasConTiempos = [];
        foreach ($usuariosConIncidenciasResueltasOCerradas as $usuario) {
            foreach ($usuario->incidenciasResueltasOcerradas as $incidencia) {
                $tipoIncidencia = $incidencia->tipo;
                $tiempoResolucion = $incidencia->duracion;

                if (!isset($tiposIncidenciasConTiempos[$tipoIncidencia])) {
                    $tiposIncidenciasConTiempos[$tipoIncidencia] = 0;
                }

                $tiposIncidenciasConTiempos[$tipoIncidencia] += $tiempoResolucion;
            }
        }
        return view('exports.incidencias_resueltas_tiempo_por_tipo', compact('tiposIncidenciasConTiempos'));
    }
}
