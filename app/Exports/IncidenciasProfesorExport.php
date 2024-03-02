<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithProperties;

/**
 * Clase que representa una exportación de incidencias creados por el profesor logueado para su visualización en una vista.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 * Implementa la interfaz WithProperties para definir propieades al archivo.
 */
class IncidenciasProfesorExport implements FromView, WithProperties
{
    /**
     * Aplicar propiedades al archivo generado.
     *
     * @return array Propiedades definidas.
     */
    public function properties(): array
    {
        return [
            'title' => 'Incidencias - Profesor'
        ];
    }

    /**
     * Obtiene la vista que representa la exportación de incidencias.
     *
     * @return View La vista que contiene la información de todas las incidencias.
     */
    public function view(): View
    {
        $profesor = auth()->user();
        $incidencias = Incidencia::where('creador_id', $profesor->id)->get();

        return view('exports.incidencias_profesor', [
            'incidencias' => $incidencias,
        ]);
    }
}
