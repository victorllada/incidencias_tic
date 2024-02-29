<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IncidenciasResueltasTiempoPorTipoExport implements FromView
{
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
