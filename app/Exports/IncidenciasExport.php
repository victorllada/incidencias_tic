<?php

namespace App\Exports;

use App\Models\Incidencia;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IncidenciasExport implements FromView
{
    public function view(): View
    {
        return view('exports.incidencias', [
            'incidencias' => Incidencia::all()
        ]);
    }
}
