<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class IncidenciasAbiertasUsuarioExport implements FromView
{
    public function view(): View
    {
        $usuariosConIncidenciasAbiertas = User::whereHas('incidenciasAbiertas')->get();
        return view('exports.incidencias_abiertas_usuarios', compact('usuariosConIncidenciasAbiertas'));
    }
}
