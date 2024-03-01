<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearUsuarioRequest;
use App\Http\Requests\ModificarUsuarioRequest;
use App\Models\Comentario;
use App\Models\Departamento;
use App\Models\Incidencia;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::all();
        return view('usuarios.index', compact('usuarios'));
    }

    /*
    * Funcion para poder enviar los usuarios a ajax
    */
    public function datosUsuarios()
    {
        $usuariosJSON = User::all();
        //Devolvemos el JSON
        return response()->json($usuariosJSON);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departamentos = Departamento::all();
        return view('usuarios.create', compact('departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CrearUsuarioRequest $request, User $usuario)
    {
        try {
            // Iniciar la transacción
            DB::beginTransaction();

            $usuario->nombre_completo = $request->nombre;

            $usuario->name = $request->name;

            $usuario->email = $request->email;

            $nombre_dep = Departamento::where('id', $request->departamento)->first();

            $usuario->id_departamento = $request->departamento;

            $usuario->nombre_departamento = $nombre_dep->nombre;

            /*Falta el set del rol*/

            //Guardamos el usuario
            $usuario->save();

            // Confirmar la transacción
            DB::commit();

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
        } catch (Exception $e) {

            //Cancelamos la transacion
            DB::rollBack();

            return redirect()->route('usuarios.index')->with('error', 'No se pudo crear el usuario.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $usuario)
    {
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        $departamentos = Departamento::all();
        return view('usuarios.edit', compact('usuario', 'departamentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ModificarUsuarioRequest $request, User $usuario)
    {
        try {
            // Iniciar la transacción
            DB::beginTransaction();

            $usuario->nombre_completo = $request->nombre;

            $usuario->email = $request->email;

            /*Falta el set del rol*/

            //Guardamos el usuario
            $usuario->save();

            // Confirmar la transacción
            DB::commit();

            return redirect()->route('usuarios.index')->with('success', 'Usuario modificado correctamente.');
        } catch (Exception $e) {

            //Cancelamos la transacion
            DB::rollBack();

            return redirect()->route('usuarios.index')->with('error', 'No se pudo modificar el usuario.');
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $usuario)
    {
        try {
            // Iniciar la transacción
            DB::beginTransaction();

            //Obtenemos todos los comentarios del usuario
            $comentarios = Comentario::where('personal_id', $usuario->id)->get();

            //Borramos los caomentarios
            foreach ($comentarios as $comentario) {
                $comentario->delete();
            }

            // Desvincular al usuario de las incidencias creadas
            //Incidencia::where('creador_id', $usuario->id)->update(['creador_id' => 0]);

            // Desvincular al usuario de las incidencias asignadas
            $usuario->incidenciasAsignadas()->detach();

            //Borramos el usuario
            $usuario->delete();

            // Confirmar la transacción
            DB::commit();

            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
        } catch (Exception $e) {

            dd($e);

            //Cancelamos la transacion
            DB::rollBack();

            return redirect()->route('usuarios.index')->with('error', 'No se pudo eliminar el usuario.');
        }
    }
}
