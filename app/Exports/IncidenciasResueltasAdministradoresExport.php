<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithProperties;

/**
 * Clase que representa una exportación de usuarios administradores con incidencias resueltas para su visualización en una vista.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 * Implementa la interfaz WithProperties para definir propieades al archivo.
 */
class IncidenciasResueltasAdministradoresExport implements FromView, WithProperties
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
