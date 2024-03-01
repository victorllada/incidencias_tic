<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

/**
 * Clase que representa una exportación de usuarios administradores con incidencias resueltas para su visualización en una vista.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 * Implementa la interfaz ShouldAutoSize para auto ajustar el tamaño de la tabla.
 */
class IncidenciasResueltasAdministradoresExport implements FromView, ShouldAutoSize
{
    /**
     * Obtiene la vista que representa la exportación de usuarios administradores con incidencias resueltas.
     *
     * @return View La vista que contiene la información de los usuarios administradores con incidencias resueltas.
     */
    public function view(): View
    {
        $usuariosConIncidenciasResueltas = User::role('administrador')
            ->whereHas('incidenciasResueltas')
            ->get();
        return view('exports.incidencias_resueltas_administradores', compact('usuariosConIncidenciasResueltas'));
    }
}
