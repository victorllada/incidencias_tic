<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

/**
 * Clase que representa una exportación de usuarios con incidencias abiertas para su visualización en una vista.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 * Implementa la interfaz ShouldAutoSize para auto ajustar el tamaño de la tabla.
 */
class IncidenciasAbiertasUsuarioExport implements FromView, ShouldAutoSize
{
    /**
     * Obtiene la vista que representa la exportación de usuarios con incidencias abiertas.
     *
     * @return View La vista que contiene la información de los usuarios con incidencias abiertas.
     */
    public function view(): View
    {
        $usuariosConIncidenciasAbiertas = User::whereHas('incidenciasAbiertas')->get();
        return view('exports.incidencias_abiertas_usuarios', compact('usuariosConIncidenciasAbiertas'));
    }
}
