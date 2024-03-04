<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearComentarioRequest;
use App\Mail\EnvioCorreo;
use App\Models\Comentario;
use App\Models\Incidencia;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use SplFileInfo;

class ComentarioController extends Controller
{

    /**
     * Guarda el nuevo comentario en la base de datos
     *
     * @param  App\Http\Requests\CrearComentarioRequest
     * @return \Illuminate\Support\Facades\Redirect Redirije a una vista u otra dependiendo del resultado
     */
    public function store(CrearComentarioRequest $request)
    {
        $comentarioEnviado = false;

        try {
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

            DB::commit();

            $incidencia = Incidencia::find($request->incidencia_id);

            $comentarioEnviado = true;
        } catch (Exception $e) {

            $incidencia = Incidencia::find($request->incidencia_id);

            if ($incidencia) {

                DB::rollBack();

                return redirect()->route('incidencias.show', $incidencia)->with('error', 'No se pudo enviar el comentario.');
            } else {

                return redirect()->route('incidencias.index')->with('error', 'No se pudo encontrar la incidencia asociada al comentario. Detalles: ' . $e->getMessage());
            }
        }

        // Si se ha creado correctamente el comentario enviamos un email
        if ($comentarioEnviado) {
            try {
                // Envío de correo poniéndolo en cola para que no interrumpa la redirección
                //Mail::to([$incidencia->creador->email])->queue(new EnvioCorreo($incidencia, 'comentado'));

                //Redirección al show con mensaje de exito
                return redirect()->route('incidencias.show', $incidencia)->with('success', 'Comentario enviado.');
            } catch (Exception $e) {
                //Redirección al show con mensaje de error
                return redirect()->route('incidencias.show', $incidencia)->with('error', 'Comentario enviado. No se ha podido enviar el email. Detalles: ' . $e->getMessage());
            }
        }
    }


    /**
     * Devuelve la descarga del archivo
     *
     * @param  int  $id  Identificador único del comentario.
     * @return \Illuminate\Contracts\Routing\ResponseFactory::download devuelve la respuesta para la descarga
     */
    public function descargarComentarioArchivo(int $id)
    {
        $coment = Comentario::find($id);
        $creadorIncidencia = $coment->incidencia->creador_id;

        $user = auth()->user();

        if (!$user->hasRole('administrador') && $user->id !== $creadorIncidencia) {
            //abort(403, 'No tiene permisos para descargar el adjunto de este comentario.');
            return redirect()->route('incidencias.index')->with('error', 'No tiene permisos para descargar el adjunto de este comentario.');
        }

        if (!$coment || !$coment->adjunto_url) {
            return redirect()->route('incidencias.index')->with('error', 'No se encuentra el adjunto o no tiene.');
        }

        // Ruta del archivo en el sistema de archivos
        $rutaArchivo = public_path('assets/' . $coment->adjunto_url);

        // Obtener la informacion del archivo
        $infoArchivo = new SplFileInfo($rutaArchivo);

        $nombreArchivo = "comentario-" . $id . '.' . $infoArchivo->getExtension();

        return response()->download($rutaArchivo, $nombreArchivo);
    }
}
