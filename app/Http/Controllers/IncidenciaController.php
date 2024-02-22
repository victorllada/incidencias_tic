<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //$incidencias = Incidencia::all();
        //return view('incidencias.index', compact('incidencias'));
        //return response()->json($incidencias);

        //$incidencias = Incidencia::all();
        $incidencias = Incidencia::with(['subtipo', 'creador', 'responsable', 'equipo', 'comentarios'])->get();

        /*
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($incidencias);
        }
        */
        return view("incidencias.index", compact('incidencias'));

        return view('incidencias.index');
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

            $datosIncidencia = Incidencia::with(['subtipo', 'creador', 'responsable', 'equipo', 'comentarios'])->findOrFail($incidencia);

            return response()->json($datosIncidencia);
        }

        return view('incidencias.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incidencia $incidencia)
    {
        return view('incidencias.edit', compact('incidencia'));
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
