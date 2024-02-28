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
        $incidenciasJSON = Incidencia::with(['subtipo', 'creador', 'equipo', 'comentarios'])->get();
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
            DB::beginTransaction();

            //Falta que si el usuario no tiene departamento asignado, al crear la incidencia se le muestre el departamento, y se le asigne el que elija
            //Falta que si el usuario no tiene asignado correo , al crear una incidencia se le muestre el correo, y se le asigne el que introduzca

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
    public function update(ModificarIncidenciaRequest $request, string $id)
    {
        try {
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

            //$incidencia->fecha_creacion = now();
            $incidencia->descripcion = $request->descripcion;
            $incidencia->actuaciones = $request->actuaciones;
            $incidencia->estado =  $request->estado;
            $incidencia->prioridad = $request->prioridad;

            $incidencia->duracion = $request->duracion; //Solo sale cuando la incidencia esta resuelta o cerrada

            if ($request->hasFile('fichero')) {
                Storage::disk('discoAssets')->delete($incidencia->adjunto_url);
                $incidencia->adjunto_url = $request->file('fichero')->store('adjunto', 'discoAssets');
            } else {
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

            return redirect()->route('incidencias.show', compact('incidencia'))->with('success', 'Incidencia creada correctamente.');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return redirect()->route('incidencias.show', compact('incidencia'))->with('error', 'No se pudo crear la incidencia. Detalles: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Método que exporta todas las incidencias en el formato indicado por parámetro.
     *
     * @param string $formato Formato a exportar.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportarTodas(string $formato)
    {
        $fechaYHoraExportacion = date('YmdHis');

        return match($formato) {
            'pdf' => Excel::download(new IncidenciasExport, $fechaYHoraExportacion . '_Incidencias.pdf', \Maatwebsite\Excel\Excel::DOMPDF),
            'xlsx' => Excel::download(new IncidenciasExport, $fechaYHoraExportacion . '_Incidencias.xlsx'),
            'csv' => Excel::download(new IncidenciasExport, $fechaYHoraExportacion . '_Incidencias.csv', \Maatwebsite\Excel\Excel::CSV)
        };
    }

    /**
     * Método que exporta todas las incidencias resueltas por cada administrador en el formato indicado por parámetro.
     *
     * @param string $formato Formato a exportar.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportarIncidenciasResueltasAdministradores(string $formato)
    {
        $fechaYHoraExportacion = date('YmdHis');

        return match($formato) {
            'pdf' => Excel::download(new IncidenciasResueltasAdministradoresExport, $fechaYHoraExportacion . '_Incidencias_Resueltas_Administradores.pdf', \Maatwebsite\Excel\Excel::DOMPDF),
            'xlsx' => Excel::download(new IncidenciasResueltasAdministradoresExport, $fechaYHoraExportacion . '_Incidencias_Resueltas_Administradores.xlsx'),
            'csv' => Excel::download(new IncidenciasResueltasAdministradoresExport, $fechaYHoraExportacion . '_Incidencias_Resueltas_Administradores.csv', \Maatwebsite\Excel\Excel::CSV)
        };
    }

    /**
     * Método que exporta todas las incidencias abiertas por cada usuario en el formato indicado por parámetro.
     *
     * @param string $formato Formato a exportar.
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function exportarIncidenciasAbiertasUsuarios(string $formato)
    {
        $fechaYHoraExportacion = date('YmdHis');

        return match($formato) {
            'pdf' => Excel::download(new IncidenciasAbiertasUsuarioExport, $fechaYHoraExportacion . '_Incidencias_Abiertas_Usuarios.pdf', \Maatwebsite\Excel\Excel::DOMPDF),
            'xlsx' => Excel::download(new IncidenciasAbiertasUsuarioExport, $fechaYHoraExportacion . '_Incidencias_Abiertas_Usuarios.xlsx'),
            'csv' => Excel::download(new IncidenciasAbiertasUsuarioExport, $fechaYHoraExportacion . '_Incidencias_Abiertas_Usuarios.csv', \Maatwebsite\Excel\Excel::CSV)
        };
    }
}
