<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{
    /**
     * Muestra la pagina de index de incidecnias
     *
     * @return Illuminate\Routing\Redirector::action
     */
    public function __invoke(Request $request)
    {
        return redirect()->action([IncidenciaController::class,'index']);
    }
}
