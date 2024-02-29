<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IncidenciaExport implements FromView
{
    public function __construct(private Incidencia $incidencia)
    {
    }

    public function view(): View
    {
        $incidencia = $this->incidencia;
        return view('exports.incidencia', compact('incidencia'));
    }
}
