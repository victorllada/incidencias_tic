<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) //Si usamos la opcion comentada debemos de usar como parametro: Request $request
    {
        //Soy @cesartg11
        //Dejo esta parte que devuelve la vista y el JSON si el request es ajax o acepta JSON

        // Recogemos todas las incidencias
        $incidencias = Incidencia::all();

        // Si es una solicitud AJAX o acepta JSON, devolvemos JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($incidencias);
        }

        // Devuelve tambien la vista
        return view('incidencias.index');



        /*En este caso recogemos todas las incidencias y ademas con el resto de tablas relacionadas con incidencias

        // Recogemos todas las incidencias con relaciones cargadas
        $incidencias = Incidencia::with(['subtipo', 'creador', 'responsable', 'equipo', 'comentarios'])->get();

        // Si es una solicitud AJAX o acepta JSON, devolvemos JSON
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json($incidencias);
        }

        // Si no es una solicitud AJAX, devolvemos la vista y el JSON
        return view('incidencias.index', ['incidencias' => $incidencias, 'jsonIncidencias' => $incidencias->toJson()]);
        */



        /*En esta parte que esta comentada, independientemente de la solicitud, devuelve colección, JSON y vista

        // Recogemos todas las incidencias
        $incidencias = Incidencia::all();

        // Devolvemos la vista y el JSON
        return view('incidencias.index', ['incidencias' => $incidencias, 'jsonIncidencias' => $incidencias->toJson()]);
        */
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
