<?php

namespace App\Http\Controllers;

use App\Models\Incidencia;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()//Si usamos la opcion comentada debemos de usar como parametro: Request $request
    {
        //Soy @cesartg11
        //Dejo comentada esta parte, la cual trata de "filtrar" por request, si es de ajax devuelve el json, y si no es ajax devuelve vista y coleccion/array de incidencias
        //Lo dejo aquí por si en un futuro es necesario, dado que actualmente no sabemos realmente como hacerlo.

        /*
        // Recogemos todas las incidencias
        $incidencias = Incidencia::all();

        // Si es una solicitud AJAX, devolvemos solo JSON
        if ($request->ajax()) {
            return response()->json($incidencias);
        }

        // Si no es una solicitud AJAX, devolvemos la vista y el JSON
        return view('incidencias.index', ['incidencias' => $incidencias, 'jsonIncidencias' => $incidencias->toJson()]);
        */

        //En esta parte que no esta comentada, independientemente de la solicitud, devuelve colección, JSON y vista

        // Recogemos todas las incidencias
        $incidencias = Incidencia::all();

        // Devolvemos la vista y el JSON
        return view('incidencias.index', ['incidencias' => $incidencias, 'jsonIncidencias' => $incidencias->toJson()]);
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
