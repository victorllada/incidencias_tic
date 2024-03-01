<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;

/**
 * Clase que representa una exportación de usuarios administradores con incidencias asignadas para su visualización en una vista.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 * Implementa la interfaz ShouldAutoSize para auto ajustar el tamaño de la tabla.
 * Implementa la interfaz WithProperties para definir propieades al archivo.
 */
class IncidenciasAsignadasAdministradoresExport implements FromView, ShouldAutoSize, WithProperties
{
    /**
     * Aplicar propiedades al archivo generado.
     *
     * @return array Propiedades definidas.
     */
    public function properties(): array
    {
        return [
            'title' => 'Incidencias - Asignadas'
        ];
    }

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
