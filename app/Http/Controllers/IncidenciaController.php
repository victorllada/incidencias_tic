<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearIncidenciaRequest;
use App\Models\Aula;
use App\Models\Equipo;
use App\Models\Incidencia;
use App\Models\IncidenciaSubtipo;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $incidencias = Incidencia::all();
        return view('incidencias.index', compact('incidencias'));
    }

    /*
    * Funcion para poder enviar las incidencias a ajax
    */
    public function datosIncidencias()
    {
        $incidenciasJSON = Incidencia::with(['subtipo', 'creador','equipo', 'comentarios'])->get();
        return response()->json($incidenciasJSON);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::all();
        $aulas = Aula::all();
        return view('incidencias.create',compact('usuarios', 'aulas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearIncidenciaRequest $request)
    {
        try {
            DB::beginTransaction();

            $incidencia = new Incidencia();

            $incidencia->tipo = $request->tipo;

            // Buscar el ID de la subincidencia, segun tipo, subtipo y subsubtipo(si hay) elegido, en la tabla incidencias_subtipos
            $incidencia_subtipo_query  = IncidenciaSubtipo::where('tipo', $request->tipo)
                ->where('subtipo_nombre', $request->input('sub-tipo'));
            if (!is_null($request->input('sub-sub-tipo'))) {
                $incidencia_subtipo_query->where('sub_subtipo', $request->input('sub-sub-tipo'));
            }

            //Recogemos el primer registro con esas caracteristicas
            $incidencia_subtipo = $incidencia_subtipo_query->first();
            // Obtener el ID
            $idSubincidencia = $incidencia_subtipo->id;
            //Metemos el id de subincidencia en el campo correspondiente
            $incidencia->subtipo_id = $idSubincidencia;

            $incidencia->fecha_creacion = now();
            $incidencia->descripcion = $request->descripcion;
            $incidencia->estado = "abierta";
            $incidencia->prioridad = $request->prioridad;

            if ($request->hasFile('fichero')) {
                $incidencia->adjunto_url = $request->file('fichero')->store('adjunto_url', 'discoAssets');
            } else {
                $incidencia->adjunto_url = null; // O cualquier valor predeterminado que desees si no hay archivo.
            }

            $incidencia->creador_id = 1; //Aqui necesitamos pasarle el id del usuario actual, o buscar por nombre y correo u algo asi, para sacar id
            //Para el id, he visto algo de auth()->id, pero no se si funcionará con spatie

            $incidencia_equipo_query = Equipo::where('etiqueta', $request->num_etiqueta)
                ->where('puesto', $request->puesto)
                ->where('aula_id', $request->aula)
                ->first();

            // Verificar si se encontró un equipo
            if ($incidencia_equipo_query) {
                $incidencia->equipo_id = $incidencia_equipo_query->id;
            } else {
                // No se encontró un equipo, establecer el equipo_id a null o cualquier otro valor predeterminado
                $incidencia->equipo_id = null;
            }

            $incidencia->save();

            $asignados = $request->input('asignado', []); // Obtén el array de checkboxes o un array vacío si no hay seleccionados
            $incidencia->responsables()->sync($asignados); //sincronizar la relación, asegurándose de que los usuarios asignados coincidan con el contenido de $asignados.

            DB::commit();

            return redirect()->route('incidencias.show', compact('incidencia'))->with('success', 'Incidencia creada correctamente.');
        } catch (Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            return redirect()->route('incidencias.index')->with('error', 'No se pudo crear la incidencia. Detalles: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */

    public function show(Request $request, Incidencia $incidencia)
    {
        $responsables = $incidencia->responsables;
        return view('incidencias.show', compact('incidencia', 'responsables'));
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
