<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IncidenciasAsignadasAdministradoresExport implements FromView
{
    public function view(): View
    {
        $usuariosConIncidenciasAsignadas = User::role('administrador')
            ->whereHas('incidenciasAsignadas')
            ->get();
        return view('exports.incidencias_asignadas_administradores', compact('usuariosConIncidenciasAsignadas'));
    }
}
