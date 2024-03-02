<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearComentarioRequest;
use App\Models\Comentario;
use App\Models\Incidencia;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use SplFileInfo;

class ComentarioController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearComentarioRequest $request)
    {
        try {
            //Comenzamos transaccion
            DB::beginTransaction();

            $comentario = new Comentario();

            $comentario->fechahora = now();

            $comentario->texto = $request->texto;

            $comentario->incidencia_num = $request->incidencia_id;

            $comentario->personal_id = auth()->user()->id;

            if ($request->hasFile('fichero')) {
                $comentario->adjunto_url = $request->file('fichero')->store('adjunto_comentarios', 'discoAssets');
            }

            $comentario->save();

            //Comitamos
            DB::commit();

            $incidencia = Incidencia::find($request->incidencia_id);

            //Redirección al show con mensaje de exito
            return Redirect::route('incidencias.show', $incidencia)->with('success', 'Comentario enviado.');
        } catch (Exception $e) {

            $incidencia = Incidencia::find($request->incidencia_id);

            if ($incidencia) {
                //Cancelamos la transacción
                DB::rollBack();

                //Redirección al show con mensaje de error
                return Redirect::route('incidencias.show', $incidencia)->with('error', 'No se pudo enviar el comentario.');
            } else {
                // Si no se puede encontrar la incidencia, redirigimos al index
                return redirect()->route('incidencias.index')->with('error', 'No se pudo encontrar la incidencia asociada al comentario.');
            }
        }
    }

    public function descargarComentarioArchivo(int $id)
    {
        // Obtener el comentario por ID
        $coment = Comentario::find($id);

        if (!$coment || !$coment->adjunto_url) {
            abort(404);
        }

        // Ruta del archivo en el sistema de archivos
        $rutaArchivo = public_path('assets/' . $coment->adjunto_url);

        // Obtener el tipo de archivo
        $infoArchivo = new SplFileInfo($rutaArchivo);

        //Ponemos el nombre del archivo
        $nombreArchivo = "comentario-" . $id . '.' . $infoArchivo->getExtension();

        // Devolver la respuesta para la descarga
        return response()->download($rutaArchivo, $nombreArchivo);
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
