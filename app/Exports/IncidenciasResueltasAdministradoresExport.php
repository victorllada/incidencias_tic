<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IncidenciasResueltasAdministradoresExport implements FromView
{
    public function view(): View
    {
        $usuariosConIncidenciasResueltas = User::role('administrador')
            ->whereHas('incidenciasResueltas')
            ->get();
        return view('exports.incidencias_resueltas_administradores', compact('usuariosConIncidenciasResueltas'));
    }
}
