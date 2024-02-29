<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IncidenciasTiempoDedicadoExport implements FromView
{
    public function view(): View
    {
        return view('exports.incidencias_tiempo_dedicado', [
            'incidencias' => Incidencia::all()
        ]);
    }
}
