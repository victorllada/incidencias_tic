<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;

/**
 * Clase que representa una exportación de usuarios con incidencias abiertas para su visualización en una vista.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 * Implementa la interfaz ShouldAutoSize para auto ajustar el tamaño de la tabla.
 * Implementa la interfaz WithProperties para definir propieades al archivo.
 */
class IncidenciasAbiertasUsuarioExport implements FromView, ShouldAutoSize, WithProperties
{
    /**
     * Aplicar propiedades al archivo generado.
     *
     * @return array Propiedades definidas.
     */
    public function properties(): array
    {
        return [
            'title' => 'Incidencias - Abiertas'
        ];
    }

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
