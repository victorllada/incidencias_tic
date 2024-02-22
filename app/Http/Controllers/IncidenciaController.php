<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$incidencias = Incidencia::all();
        $incidencias = Incidencia::all();
        return view("incidencias.index", compact('incidencias'));
        //return view('incidencias.index', compact('incidencias'));
        //return response()->json($incidencias);
    }

    public function datosIndex()
    {
        $incidencias = Incidencia::all();
        return response()->json($incidencias);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('incidencias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Incidencia $incidencia)
    {
        //return view('incidencias.show');
        if ($request->ajax() || $request->wantsJson()) {
            if (!$incidencia) {
                return response()->json(['error' => 'Incidencia no encontrada'], 404);
            }

            return response()->json($incidencia);
        }

        return view('incidencias.show');
    }

    /* Esta funcion sirve para enviar datos JSON a AJAX, demomento la dejamos por si la de arriba no funciona
    public function datosShow(int $id)
    {
        $incidencias = Incidencia::where('id', '=', $id)->firstOrFail();
        return response()->json($incidencias);
    }*/


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incidencia $incidencia)
    {
        return view('incidencias.edit', compact('animal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
