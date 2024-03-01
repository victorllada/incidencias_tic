<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

/**
 * Clase que representa una exportación de incidencias con el tiempo dedicado para su visualización en una vista.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 */
class IncidenciasTiempoDedicadoExport implements FromView
{
    /**
     * Obtiene la vista que representa la exportación de incidencias con el tiempo dedicado.
     *
     * @return View La vista que contiene la información de todas las incidencias con el tiempo dedicado.
     */
    public function view(): View
    {
        return view('exports.incidencias_tiempo_dedicado', [
            'incidencias' => Incidencia::all()
        ]);
    }
}
