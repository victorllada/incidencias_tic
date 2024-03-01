<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

/**
 * Clase que representa una exportación de incidencias para su visualización en una vista.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 * Implementa la interfaz ShouldAutoSize para auto ajustar el tamaño de la tabla.
 */
class IncidenciasExport implements FromView, ShouldAutoSize
{
    /**
     * Obtiene la vista que representa la exportación de incidencias.
     *
     * @return View La vista que contiene la información de todas las incidencias.
     */
    public function view(): View
    {
        return view('exports.incidencias', [
            'incidencias' => Incidencia::all()
        ]);
    }
}
