<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

/**
 * Clase que representa una exportación de usuarios administradores con incidencias asignadas para su visualización en una vista.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 */
class IncidenciasAsignadasAdministradoresExport implements FromView
{
    /**
     * Obtiene la vista que representa la exportación de usuarios administradores con incidencias asignadas.
     *
     * @return View La vista que contiene la información de los usuarios administradores con incidencias asignadas.
     */
    public function view(): View
    {
        $usuariosConIncidenciasAsignadas = User::role('administrador')
            ->whereHas('incidenciasAsignadas')
            ->get();
        return view('exports.incidencias_asignadas_administradores', compact('usuariosConIncidenciasAsignadas'));
    }
}
