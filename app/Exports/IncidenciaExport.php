<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

/**
 * Clase que representa una exportación de incidencia para su visualización en una vista.
 *
 * Implementa la interfaz FromView para obtener los datos desde una vista.
 */
class IncidenciaExport implements FromView
{
    /**
     * Constructor que declara e inicializa la incidencia a exportar.
     *
     * @var Incidencia Incidencia a exportar.
     */
    public function __construct(private Incidencia $incidencia)
    {
    }

    /**
     * Obtiene la vista que representa la exportación de incidencia.
     *
     * @return View La vista que contiene la información de la incidencia.
     */
    public function view(): View
    {
        $incidencia = $this->incidencia;
        return view('exports.incidencia', compact('incidencia'));
    }
}
