<?php

namespace App\Http\Controllers;

use App\Exports\IncidenciasAbiertasUsuarioExport;
use App\Exports\IncidenciasExport;
use App\Exports\IncidenciasResueltasAdministradoresExport;
use App\Http\Requests\CrearIncidenciaRequest;
use App\Http\Requests\ModificarIncidenciaRequest;
use App\Mail\EnvioCorreo;
use App\Models\Aula;
use App\Models\Departamento;
use App\Models\Equipo;
use App\Models\Incidencia;
use App\Models\IncidenciaSubtipo;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

use function PHPUnit\Framework\isNull;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // Comprobamos si el rol del usuario es administrador.
        // Si lo es, devolvemos todas las incidencias.
        // En caso contrario (rol de profesor), devolvemos las incidencias creadas por el usuario.
        $incidencias = $user->hasRole('administrador') ? Incidencia::all() : Incidencia::where('creador_id', $user->id)->get();

        return view('incidencias.index', compact('incidencias'));
    }

    /*
    * Funcion para poder enviar las incidencias a ajax
    */
    public function datosIncidencias()
    {

        $user = auth()->user();

        // Comprobamos si el rol del usuario es administrador.
        // Si lo es, devolvemos todas las incidencias.
        // En caso contrario (rol de profesor), devolvemos las incidencias creadas por el usuario.
        $incidenciasJSON = $user->hasRole('administrador') ? Incidencia::with(['subtipo', 'creador', 'equipo', 'comentarios'])->get() : Incidencia::where('creador_id', $user->id)->with(['subtipo', 'creador', 'equipo', 'comentarios'])->get();

        //Devolvemos el JSON
        return response()->json($incidenciasJSON);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::role('administrador')->get();
        $aulas = Aula::all();
        $departamentos = Departamento::all();
        return view('incidencias.create', compact('usuarios', 'aulas', 'departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearIncidenciaRequest $request)
    {
        try {
            //Si el usuario no tiene email, le asignaremos el email qe inserte.
            if (is_null(auth()->user()->email)) {

                //Sacamos usuario en una variable
                $user = auth()->user();

                //Hacemos que el mail sea el introducido
                $user->email = $request->email;

                //Guardamos el user
                $user->save;
            }

            //Si el usuario no tiene departamento_id o nombre_departamento, le asignaremos el departamento que elija.
            if (is_null(auth()->user()->id_departamento) || is_null(auth()->user()->nombre_departamento)) {

                //Sacamos usuario en una variable
                $user = auth()->user();

                //Buscamos el departamento por id y sacamos el objeto
                $objDept = Departamento::where('id', $request->departamento)->get();

                //Hacemos que el campo departamento id sea el introducido
                $user->departamento_id = $request->departamento;

                //Hacemos que el campo nombre de departamento sea el introducido
                $user->nombre_departamento = $objDept->nombre_departamento;

                //Guardamos el user
                $user->save;
            }

            DB::beginTransaction();

            $incidencia = new Incidencia();

            $incidencia->tipo = $request->tipo;

            $subtipo = $request->input('sub-tipo');
            $subsubtipo = $request->input('sub-sub-tipo');

            // Buscar el ID de la subincidencia, segun tipo, subtipo(si hay) y subsubtipo(si hay) elegido, en la tabla incidencias_subtipos
            $incidencia_subtipo_query = IncidenciaSubtipo::where('tipo', $request->tipo)
                ->when(!is_null($subtipo), function ($query) use ($subtipo) {
                    return $query->where('subtipo_nombre', $subtipo);
                })
                ->when(!is_null($subsubtipo), function ($query) use ($subsubtipo) {
                    return $query->where('sub_subtipo', $subsubtipo);
                });

            //Recogemos el primer registro con esas caracteristicas
            $incidencia_subtipo = $incidencia_subtipo_query->first();
            // Obtener el ID
            $idSubincidencia = $incidencia_subtipo->id;
            //Metemos el id de subincidencia en el campo correspondiente
            $incidencia->subtipo_id = $idSubincidencia;

            $incidencia->fecha_creacion = now();
            $incidencia->descripcion = $request->descripcion;
            $incidencia->estado = "ABIERTA";
            $incidencia->prioridad = $request->prioridad;

            if ($request->hasFile('fichero')) {
                $incidencia->adjunto_url = $request->file('fichero')->store('adjunto', 'discoAssets');
            } else {
                $incidencia->adjunto_url = null;
            }

            $incidencia->creador_id = auth()->user()->id;

            $incidencia_equipo_query = Equipo::where('etiqueta', $request->num_etiqueta)
                ->where('puesto', $request->puesto)
                ->where('aula_id', $request->aula)
                ->first();

            // Verificar si se encontró un equipo
            if ($incidencia_equipo_query) {
                $incidencia->equipo_id = $incidencia_equipo_query->id;
            } else {
                // No se encontró un equipo, establecer el equipo_id a null
                $incidencia->equipo_id = null;
            }

            $incidencia->save();

            $asignados = $request->input('asignado', []); // Obtenemos el array de checkboxes o un array vacío si no hay seleccionados
            $incidencia->responsables()->sync($asignados); //sincronizamos la relación, asegurándo de que los usuarios asignados coincidan con el contenido de $asignados.

            DB::commit();

            // Envío de correo poniéndolo en cola para que no interrumpa la redirección
            //Mail::to([$incidencia->creador->email])->queue(new EnvioCorreo($incidencia, 'creado'));

            return redirect()->route('incidencias.show', compact('incidencia'))->with('success', 'Incidencia creada correctamente.');
        } catch (Exception $e) {
            dd($e);
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
        $usuarios = User::role('administrador')->get();
        $aulas = Aula::all();
        return view('incidencias.edit', compact('incidencia', 'usuarios', 'aulas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModificarIncidenciaRequest $request, Incidencia $incidencia)
    {
        try {
            DB::beginTransaction();

            $incidencia->tipo = $request->tipo;

            $subtipo = $request->input('sub-tipo');
            $subsubtipo = $request->input('sub-sub-tipo');

            // Buscar el ID de la subincidencia, segun tipo, subtipo(si hay) y subsubtipo(si hay) elegido, en la tabla incidencias_subtipos
            $incidencia_subtipo_query = IncidenciaSubtipo::where('tipo', $request->tipo)
                ->when(!is_null($subtipo), function ($query) use ($subtipo) {
                    return $query->where('subtipo_nombre', $subtipo);
                })
                ->when(!is_null($subsubtipo), function ($query) use ($subsubtipo) {
                    return $query->where('sub_subtipo', $subsubtipo);
                });

            //Recogemos el primer registro con esas caracteristicas
            $incidencia_subtipo = $incidencia_subtipo_query->first();
            // Obtener el ID
            $idSubincidencia = $incidencia_subtipo->id;
            //Metemos el id de subincidencia en el campo correspondiente
            $incidencia->subtipo_id = $idSubincidencia;

            //$incidencia->fecha_creacion = now();
            $incidencia->descripcion = $request->descripcion;
            $incidencia->actuaciones = $request->actuaciones;
            //$incidencia->estado =  $request->estado;
            $incidencia->estado =  "ABIERTA";//Hay que poner la de arriba
            $incidencia->prioridad = $request->prioridad;

            $incidencia->duracion = $request->duracion; //Solo sale cuando la incidencia esta resuelta o cerrada

            //Comprobamos que el request traiga el campo fichero
            if ($request->hasFile('fichero')) {
                //Eliminamos el fichero antiguo si existe
                if (!is_null($incidencia->adjunto_url)) {
                    Storage::disk('discoAssets')->delete($incidencia->adjunto_url);
                }
                // Almacenamos el nuevo fichero
                $incidencia->adjunto_url = $request->file('fichero')->store('adjunto', 'discoAssets');
            } else {
                // Si no hay un nuevo archivo, establecer el adjunto_url a null
                $incidencia->adjunto_url = null;
            }

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

            $asignados = $request->input('asignado', []); // Obtenemos el array de checkboxes o un array vacío si no hay seleccionados
            $incidencia->responsables()->sync($asignados); //sincronizamos la relación, asegurándo de que los usuarios asignados coincidan con el contenido de $asignados.

            DB::commit();

            // Envío de correo poniéndolo en cola para que no interrumpa la redirección
            //Mail::to([$incidencia->creador->nombre_completo])->queue(new EnvioCorreo($incidencia, 'creado'));

            return redirect()->route('incidencias.show', compact('incidencia'))->with('success', 'Incidencia modificada correctamente.');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->route('incidencias.show', compact('incidencia'))->with('error', 'No se pudo modificar la incidencia. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {

            // Buscar la incidencia por su ID
            $incidencia = Incidencia::findOrFail($id);

            // Iniciar la transacción
            DB::beginTransaction();

            // Eliminar la incidencia
            $incidencia->delete();

            // Confirmar la transacción
            DB::commit();
        } catch (Exception $e) {
            // Deshacer la transacción en caso de error
            DB::rollBack();

            //Redirigiar al index con mensaje de error
            return redirect()->route('incidencias.index')->with('error', 'Error al eliminar la incidencia. Detalles: ' . $e->getMessage());
        }

        // Redirigir al index después de la eliminación con mensaje de exito
        return redirect()->route('incidencias.index')->with('success', 'Incidencia eliminada correctamente.');
    }

    /**
     * Método para exportar incidencias del tipo y formato indicado por parámetro.
     *
     * @param string $tipo Tipo de incidencias a exportar ('todas', 'resueltas', 'abiertas').
     * @param string $formato Formato a exportar.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportarIncidencias(string $tipo, string $formato)
    {
        $fechaYHoraExportacion = date('YmdHis');

        $claseExport = match ($tipo) {
            'todas' => IncidenciasExport::class,
            'resueltas' => IncidenciasResueltasAdministradoresExport::class,
            'abiertas' => IncidenciasAbiertasUsuarioExport::class,
            default => null,
        };

        return match ($formato) {
            'pdf' => Excel::download(new $claseExport, $fechaYHoraExportacion . "_Incidencias_{$tipo}.pdf", \Maatwebsite\Excel\Excel::DOMPDF),
            'xlsx' => Excel::download(new $claseExport, $fechaYHoraExportacion . "_Incidencias_{$tipo}.xlsx"),
            'csv' => Excel::download(new $claseExport, $fechaYHoraExportacion . "_Incidencias_{$tipo}.csv", \Maatwebsite\Excel\Excel::CSV)
        };
    }
}
