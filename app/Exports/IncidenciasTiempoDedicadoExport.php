<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithProperties;

/**
 * Clase que representa una exportación de incidencias con el tiempo dedicado para su visualización en una vista.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 * Implementa la interfaz ShouldAutoSize para auto ajustar el tamaño de la tabla.
 * Implementa la interfaz WithProperties para definir propieades al archivo.
 */
class IncidenciasTiempoDedicadoExport implements FromView, WithProperties
{
    /**
     * Aplicar propiedades al archivo generado.
     *
     * @return array Propiedades definidas.
     */
    public function properties(): array
    {
        return [
            'title' => 'Incidencias - Tiempo dedicado'
        ];
    }

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
