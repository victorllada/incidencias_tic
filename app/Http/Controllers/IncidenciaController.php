<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearIncidenciaRequest;
use App\Models\Incidencia;
use App\Models\IncidenciaSubtipo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $incidenciasJSON = Incidencia::with(['subtipo', 'creador', 'responsable', 'equipo', 'comentarios'])->get();
            return response()->json($incidenciasJSON);
        }

        $incidencias = Incidencia::Paginate(10);
        return view('incidencias.index', compact('incidencias'));
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
    public function store(CrearIncidenciaRequest $request)
    {
        try {
            DB::beginTransaction();

            $incidencia = new Incidencia();

            $incidencia->id = $request->id;
            $incidencia->tipo = $request->tipo;

            /*Comprobar si lo de abajo (sacar id subincidencia) funciona, ya que el subsubtipo puede ser null e igual da fallo*/

            // Buscar el ID de la subincidencia, segun tipo, subtipo y subsubtipo elegido, en la tabla incidencias_subtipos
            $incidencia_subtipo = IncidenciaSubtipo::where('tipo', $request->tipo)
                ->where('subtipo_nombre', $request->subtipo)
                ->where('sub_subtipo', $request->subsubtipo)
                ->firstOrFail();

            // Obtener el ID
            $idSubincidencia = $incidencia_subtipo->id;
            //Metemos el id de subincidencia en el campo correspondiente
            $incidencia->subtipo_id = $idSubincidencia;

            $incidencia->fecha_creacion = $request->fecha_hora;
            $incidencia->duracion = $request->duracion;
            $incidencia->descripcion = $request->descripcion;
            $incidencia->actuaciones = $request->actuaciones;
            $incidencia->estado = $request->estado;
            $incidencia->prioridad = $request->prioridad;
            $incidencia->adjunto_url = $request->fichero;

            /*Lo de abajo, falta sacr creador_id, respinsable_id y equipo_id, con los datos que vienen abajo*/

            //$request->nombre;  nombre del creador
            //$request->asignado; asignadao a x profesor o profesores, esto ojo, no se muy bien como hacer para que sean varios profes

            //$request->departamento;
            //$request->num_etiqueta;
            //$request->aula;
            //$request->puesto;

            $incidencia->save();

            DB::commit();

            return redirect()->route('incidencias.show', compact('incidencia'))->with('success', 'Incidencia creado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('incidencias.index')->with('error', 'No se pudo crear la incidencia. Detalles: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */

    public function show(Request $request, Incidencia $incidencia)
    {
        return view('incidencias.show', compact('incidencia'));
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
