<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;

/**
 * Clase que representa una exportación de incidencias para su visualización en una vista.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 * Implementa la interfaz ShouldAutoSize para auto ajustar el tamaño de la tabla.
 * Implementa la interfaz WithProperties para definir propieades al archivo.
 */
class IncidenciasExport implements FromView, ShouldAutoSize, WithProperties
{
    /**
     * Aplicar propiedades al archivo generado.
     *
     * @return array Propiedades definidas.
     */
    public function properties(): array
    {
        return [
            'title' => 'Incidencias - Detalles'
        ];
    }

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
