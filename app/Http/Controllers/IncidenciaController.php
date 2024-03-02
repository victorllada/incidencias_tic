<?php

namespace App\Http\Controllers;

use App\Exports\EstadisticasTiposIncidenciasExport;
use App\Exports\IncidenciaExport;
use App\Exports\IncidenciasAbiertasUsuarioExport;
use App\Exports\IncidenciasAsignadasAdministradoresExport;
use App\Exports\IncidenciasExport;
use App\Exports\IncidenciasResueltasAdministradoresExport;
use App\Exports\IncidenciasResueltasTiempoPorTipoExport;
use App\Exports\IncidenciasTiempoDedicadoExport;
use App\Http\Requests\CrearIncidenciaRequest;
use App\Http\Requests\ModificarIncidenciaRequest;
use App\Mail\EnvioCorreo;
use App\Models\Aula;
use App\Models\Comentario;
use App\Models\Departamento;
use App\Models\Equipo;
use App\Models\Incidencia;
use App\Models\IncidenciaSubtipo;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use SplFileInfo;

use function PHPUnit\Framework\isNull;

class IncidenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Obtenemos el usuario logueado y lo guardamos en una variable
        $user = auth()->user();

        // Comprobamos si el rol del usuario es administrador.
        // Si lo es, devolvemos todas las incidencias.
        // En caso contrario (rol de profesor), devolvemos las incidencias creadas por el usuario.
        $incidencias = $user->hasRole('administrador') ? Incidencia::all() : Incidencia::where('creador_id', $user->id)->get();

        //Devolvemos la vista con las incidencias
        return view('incidencias.index', compact('incidencias'));
    }

    /*
    * Funcion para poder enviar las incidencias a ajax
    */
    public function datosIncidencias()
    {
        //Obtenemos el usuario logueado y lo guardamos en una variable
        $user = auth()->user();

        // Rol del usuario logueado
        $rolUsuario = $user->getRoleNames()->toArray();

        // Comprobamos si el rol del usuario es administrador.
        // Si lo es, devolvemos todas las incidencias.
        // En caso contrario (rol de profesor), devolvemos las incidencias creadas por el usuario.
        $incidencias = $user->hasRole('administrador') ? Incidencia::with(['subtipo', 'creador', 'equipo', 'comentarios'])->get() : Incidencia::where('creador_id', $user->id)->with(['subtipo', 'creador', 'equipo', 'comentarios'])->get();

        // Construir los datos del JSON
        $datosJSON = [
            'incidencias' => $incidencias->toArray(),
            'rol_usuario' => $rolUsuario,
        ];

        //Devolvemos el JSON
        return response()->json($datosJSON);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Obtenemos los usuarios con el rol administrador
        $usuarios = User::role('administrador')->get();

        //Obtenemos todas las aulas
        $aulas = Aula::all();

        //Obtenemos todos los departamentos
        $departamentos = Departamento::all();

        //Devolvemos la vista con todos los objetos y colecciones
        return view('incidencias.create', compact('usuarios', 'aulas', 'departamentos'));
    }

    /**
     * Funcion para poder enviar a ajax las etiquetas de los equipos del aula seleccionado.
     */
    public function obtenerEtiquetas(int $aulaId)
    {
        //Obtenemos los equipos del aula (id) pasado por parametro
        $etiquetas = Equipo::where('aula_id', $aulaId)->get();

        //Devolvemos un JSON con los equipos
        return response()->json($etiquetas);
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
                $userId = auth()->user()->id;

                //Sacamos el usuario por el id
                $usuario = User::where('id', $userId)->first();

                //Hacemos que el mail sea el introducido
                $usuario->email = $request->email;

                //Guardamos el user
                $usuario->save();
            }

            //Si el usuario no tiene departamento_id o nombre_departamento, le asignaremos el departamento que elija.
            if (is_null(auth()->user()->id_departamento) || is_null(auth()->user()->nombre_departamento)) {

                //Sacamos usuario en una variable
                $userId = auth()->user()->id;

                //Sacamos el usuario por el id
                $usuario = User::where('id', $userId)->first();

                //Buscamos el departamento por id y sacamos el objeto
                $objDept = Departamento::where('id', $request->departamento)->first();
                //dd($objDept);

                //Hacemos que el campo departamento id sea el introducido
                $usuario->id_departamento = $request->departamento;

                //Hacemos que el campo nombre de departamento sea el introducido
                $usuario->nombre_departamento = $objDept->nombre;

                //Guardamos el user
                $usuario->save();
            }

            //Empezamos transaccion
            DB::beginTransaction();

            //Creamos una nnueva incidencia
            $incidencia = new Incidencia();

            //Ponemos el tipo segun el seleccionado
            $incidencia->tipo = $request->tipo;

            //Guardamos en dos variables el sub-tipo y el sub-sub-tipo
            $subtipo = $request->input('sub-tipo');
            $subsubtipo = $request->input('sub-sub-tipo');

            // Buscar el ID de la subincidencia, segun tipo, subtipo(si hay) y subsubtipo(si hay) elegido, en la tabla incidencias_subtipos
            $incidencia_subtipo_query = IncidenciaSubtipo::where('tipo', $request->tipo);
            if (!is_null($subtipo)) {
                $incidencia_subtipo_query->where('subtipo_nombre', $subtipo);
            }
            if (!is_null($subsubtipo)) {
                $incidencia_subtipo_query->where('sub_subtipo', $subsubtipo);
            }

            //Recogemos el primer registro con esas caracteristicas
            $incidencia_subtipo = $incidencia_subtipo_query->first();
            // Obtener el ID
            $idSubincidencia = $incidencia_subtipo->id;
            //Metemos el id de subincidencia en el campo correspondiente
            $incidencia->subtipo_id = $idSubincidencia;

            //Fecha de creación la ponemos al momento exacto en el que se cree
            $incidencia->fecha_creacion = now();

            //Ponemos la descripcion segun la introducida
            $incidencia->descripcion = $request->descripcion;

            //El estado al crear una incidencia es por defecto ABIERTA
            $incidencia->estado = "ABIERTA";

            //Ponemos la prioridad segun la seleccionada
            $incidencia->prioridad = $request->prioridad;

            //Si se ha subido fichero, lo guardamos en la carpeta adjunto en public/assets, usando el disco discoAssets y subimos la ruta a la base de datos
            if ($request->hasFile('fichero')) {
                $incidencia->adjunto_url = $request->file('fichero')->store('adjunto', 'discoAssets');
            } else {
                $incidencia->adjunto_url = null;
            }

            //Ponemos el usuario actual com el creador
            $incidencia->creador_id = auth()->user()->id;

            //Buscamos el equipo con el aula y la etiqueta seleccionados
            $incidencia_equipo_query = Equipo::where('etiqueta', $request->num_etiqueta)
                ->where('aula_id', $request->aula)
                ->first();

            // Verificar si se encontró un equipo
            if ($incidencia_equipo_query) {
                $incidencia->equipo_id = $incidencia_equipo_query->id;
            } else {
                // No se encontró un equipo, establecer el equipo_id a null
                $incidencia->equipo_id = null;
            }

            //Guardamos el responsable
            $incidencia->responsable_id = $request->asignado;

            //Guardamos la incidencia
            $incidencia->save();

            //Comitamos
            DB::commit();

            // Envío de correo poniéndolo en cola para que no interrumpa la redirección
            //Mail::to([$incidencia->creador->email])->queue(new EnvioCorreo($incidencia, 'creado'));

            //Redirección al show con mensaje de exito
            return redirect()->route('incidencias.show', compact('incidencia'))->with('success', 'Incidencia creada correctamente.');
        } catch (Exception $e) {

            //Cancelamos la transacion
            DB::rollBack();

            //Redirección al index con mensaje de error
            return redirect()->route('incidencias.index')->with('error', 'No se pudo crear la incidencia. Detalles: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Incidencia $incidencia)
    {
        //Devolvemos la vista con la incidencia y sus responsables
        return view('incidencias.show', compact('incidencia'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Incidencia $incidencia)
    {
        //Obtenemos todos los departamentos
        $departamentos = Departamento::all();

        //Obtenemos los usuarios con el rol administrador
        $usuarios = User::role('administrador')->get();

        //Obtenemos todas las aulas
        $aulas = Aula::all();

        //Devolvemos la vista con todos los objetos y colecciones
        return view('incidencias.edit', compact('incidencia', 'usuarios', 'aulas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModificarIncidenciaRequest $request, Incidencia $incidencia)
    {
        try {
            //Comenzamos transaccion
            DB::beginTransaction();

            //Ponemos el tipo segun el seleccionado
            $incidencia->tipo = $request->tipo;

            //Guardamos en dos variables el sub-tipo y el sub-sub-tipo
            $subtipo = $request->input('sub-tipo');
            $subsubtipo = $request->input('sub-sub-tipo');

            // Buscar el ID de la subincidencia, segun tipo, subtipo(si hay) y subsubtipo(si hay) elegido, en la tabla incidencias_subtipos
            $incidencia_subtipo_query = IncidenciaSubtipo::where('tipo', $request->tipo);
            if (!is_null($subtipo)) {
                $incidencia_subtipo_query->where('subtipo_nombre', $subtipo);
            }
            if (!is_null($subsubtipo)) {
                $incidencia_subtipo_query->where('sub_subtipo', $subsubtipo);
            }

            //Recogemos el primer registro con esas caracteristicas
            $incidencia_subtipo = $incidencia_subtipo_query->first();
            // Obtener el ID
            $idSubincidencia = $incidencia_subtipo->id;
            //Metemos el id de subincidencia en el campo correspondiente
            $incidencia->subtipo_id = $idSubincidencia;

            //Ponemos la descripcion segun la introducida
            $incidencia->descripcion = $request->descripcion;

            //Ponemos las actuaciones segun las introducidas
            $incidencia->actuaciones = $request->actuaciones;

            //Ponemos el estado segun el introducida
            $incidencia->estado =  $request->estado;

            //Ponemos la prioridad segun la prioridad
            $incidencia->prioridad = $request->prioridad;

            //Ponemos la duracion segun la introducida
            $incidencia->duracion = $request->duracion;

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

            //Buscamos el equipo con el aula y la etiqueta seleccionados
            $incidencia_equipo_query = Equipo::where('etiqueta', $request->num_etiqueta)
                ->where('aula_id', $request->aula)
                ->first();


            // Verificar si se encontró un equipo
            if ($incidencia_equipo_query) {
                $incidencia->equipo_id = $incidencia_equipo_query->id;
            } else {
                // No se encontró un equipo, establecer el equipo_id a null o cualquier otro valor predeterminado
                $incidencia->equipo_id = null;
            }

            //Guardamos el responsable
            $incidencia->responsable_id = $request->asignado;

            //Guardamos la incidencia
            $incidencia->save();

            //Comitamos
            DB::commit();

            dd($incidencia);

            // Envío de correo poniéndolo en cola para que no interrumpa la redirección
            //Mail::to([$incidencia->creador->nombre_completo])->queue(new EnvioCorreo($incidencia, 'creado'));

            //Redirección al show con mensaje de exito
            return redirect()->route('incidencias.show', compact('incidencia'))->with('success', 'Incidencia modificada correctamente.');
        } catch (Exception $e) {

            dd($e);

            //Cancelamos la transacion
            DB::rollBack();

            //Redirección al index con mensaje de error
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

            //Buscamos todos los comentarios de la incidencia
            $comentarios = Comentario::where('incidencia_num', $id)->get();

            //Borramos todos los comentarios de la incidencia
            foreach ($comentarios as $comentario) {
                $comentario->delete();
            }

            // Si la incidencia tiene fichero adjunto lo eliminamos del disco
            if ($incidencia->adjunto_url != null) {
                Storage::disk('discoAssets')->delete($incidencia->adjunto_url);
            }

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
     * @param mixed $tipoOID Tipo de incidencias a exportar ('todas', 'resueltas', 'abiertas', 'asignadas', 'todasTiempoDedicado', resueltasTiempoPorTipo). Si se pasa un ID de la incidencia se exportarán los detalles de esa incidencia.
     * @param string $formato Formato a exportar ('pdf', 'xlsx' o 'csv').
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportarIncidencias(mixed $tipoOID, string $formato)
    {
        if (is_numeric($tipoOID)) {
            $id = (int)$tipoOID;
            $incidenciasExport = new IncidenciaExport(Incidencia::findOrFail($id));
        } else {
            $claseExport = match ($tipoOID) {
                'todas' => IncidenciasExport::class,
                'resueltas' => IncidenciasResueltasAdministradoresExport::class,
                'abiertas' => IncidenciasAbiertasUsuarioExport::class,
                'asignadas' => IncidenciasAsignadasAdministradoresExport::class,
                'todasTiempoDedicado' => IncidenciasTiempoDedicadoExport::class,
                'resueltasTiempoPorTipo' => IncidenciasResueltasTiempoPorTipoExport::class,
            };

            $incidenciasExport = new $claseExport;
        }

        return $this->exportarEnFormato($incidenciasExport, $formato, "_Incidencias_{$tipoOID}");
    }

    /**
     * Exporta estadísticas de tipos de incidencias en el formato especificado.
     *
     * @param string $formato Formato de exportación ('pdf', 'xlsx' o 'csv').
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportarEstadisticasTiposIncidencias($formato)
    {
        return $this->exportarEnFormato(new EstadisticasTiposIncidenciasExport, $formato, "_Estadisticas_Tipos_Incidencias");
    }

    /**
     * Método genérico para exportar datos en el formato especificado.
     *
     * @param \Maatwebsite\Excel\Concerns\FromView $exportador Instancia del exportador.
     * @param string $formato Formato de exportación ('pdf', 'xlsx' o 'csv').
     * @param string $nombreArchivoPrefijo Prefijo para el nombre del archivo generado.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    private function exportarEnFormato($incidenciasExport, string $formato, string $nombreArchivo)
    {
        $fechaYHoraExportacion = date('YmdHis');

        return match ($formato) {
            'pdf' => Excel::download($incidenciasExport, $fechaYHoraExportacion . $nombreArchivo . '.pdf', \Maatwebsite\Excel\Excel::DOMPDF),
            'xlsx' => Excel::download($incidenciasExport, $fechaYHoraExportacion . $nombreArchivo . '.xlsx'),
            'csv' => Excel::download($incidenciasExport, $fechaYHoraExportacion . $nombreArchivo . '.csv', \Maatwebsite\Excel\Excel::CSV)
        };
    }

    public function descargarArchivo(int $id)
    {
        // Obtener la incidencia por ID
        $incidencia = Incidencia::find($id);

        if (!$incidencia || !$incidencia->adjunto_url) {
            abort(404);
        }

        // Ruta del archivo en el sistema de archivos
        $rutaArchivo = public_path('assets/' . $incidencia->adjunto_url);

        // Obtener el nombre original del archivo
        $nombreArchivo = pathinfo($rutaArchivo, PATHINFO_BASENAME);

        // Obtener el tipo de archivo
        $infoArchivo = new SplFileInfo($rutaArchivo);

        //Ponemos el nombre del archivo
        $nombreArchivo = "Incidencia-" . $id . '.' . $infoArchivo->getExtension();

        // Devolver la respuesta para la descarga
        return response()->download($rutaArchivo, $nombreArchivo);
    }
}
