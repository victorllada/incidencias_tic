<?php

namespace App\Http\Controllers;

use App\Http\Requests\CrearUsuarioRequest;
use App\Models\Comentario;
use App\Models\Departamento;
use App\Models\Incidencia;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Muestra todos los usuarios
     *
     * @return view Devuelve la vista de usuarios.index
     */
    public function index()
    {
        $usuarios = User::all();
        $departamentos = Departamento::all();
        return view('usuarios.index', compact('usuarios', 'departamentos'));
    }

    /**
     * Funcion para poder enviar los usuarios a ajax
     *
     * @return Illuminate\Contracts\Routing\ResponseFactory::json
     */
    public function datosUsuarios()
    {
        $usuarios = User::all();

        $usuariosJSON = $usuarios->map(function ($usuario) {
            return [
                'id' => $usuario->id,
                'usuario' => $usuario->name,
                'nombre_completo' => $usuario->nombre_completo,
                'email' => $usuario->email,
                'departamento' => $usuario->nombre_departamento,
                'roles' => $usuario->getRoleNames()->toArray(),
            ];
        });

        //Devolvemos el JSON
        return response()->json($usuariosJSON);
    }

    /**
     * Muestra la vista para crear un usuario
     *
     * @return view Devuelve la vista de usuarios.create
     */
    public function create()
    {
        /*
        $departamentos = Departamento::all();
        $rolesDisponibles = Role::pluck('name')->toArray();
        return view('usuarios.create', compact('departamentos', 'rolesDisponibles'));
        */

        abort('404');
    }

    /**
     * Guarda el nuevo usuario en la base de datos.
     * Este método no se va a usar pero lo dejamos hecho por si en futuras actulizaciones es necesario.
     *
     * @param App\Http\Requests\CrearUsuarioRequest
     * @return Illuminate\Routing\Redirector::route Redirije a una ruta u otra dependiendo del resultado de la operación
     */
    public function store(CrearUsuarioRequest $request, User $usuario)
    {
        /*
        try {
            // Iniciar la transacción
            DB::beginTransaction();

            $usuario->nombre_completo = $request->nombre_completo;

            $usuario->name = $request->name;

            $usuario->email = $request->email;

            $nombre_dep = Departamento::where('id', $request->departamento)->first();

            $usuario->id_departamento = $request->departamento;

            $usuario->nombre_departamento = $nombre_dep->nombre;

            //Guardamos el usuario
            $usuario->save();

            // Asignar el rol al usuario
            $usuario->assignRole($request->rol);

            // Confirmar la transacción
            DB::commit();

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
        } catch (Exception $e) {

            //Cancelamos la transacion
            DB::rollBack();

            return redirect()->route('usuarios.index')->with('error', 'No se pudo crear el usuario.');
        }
        */
        abort('404');
    }

    /**
     * Muestra la vista de show usuarios
     *
     * @param App\Models\User
     * @return view Devuelve la vista de usuarios.show
     */
    public function show(User $usuario)
    {
        /*
        return view('usuarios.show', compact('usuario'));
        */
        abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $usuario)
    {
        $departamentos = Departamento::all();
        $rolesDisponibles = Role::pluck('name')->toArray();
        return view('usuarios.edit', compact('usuario', 'departamentos', 'rolesDisponibles'));
    }

    /**
     * Modifica el usuario pasado por parametro en la base de datos.
     *
     * @param App\Http\Requests\ModificarUsuarioRequest
     * @param App\Models\User
     * @return Illuminate\Routing\Redirector::route Redirije a una ruta u otra dependiendo del resultado de la operación
     */
    public function update(Request $request, User $usuario)
    {
        try {

            DB::beginTransaction();

            // Verificar si el usuario está actualizando su propio perfil
            $esUsuarioPropio = $usuario->id == auth()->user()->id;

            // Validación
            $rules = [
                'nombre_completo' => 'required|string',
                'email' => 'required|email',
            ];

            $messages = [
                'nombre_completo.required' => 'El nombre es obligatorio.',
                'nombre_completo.string' => 'El nombre debe ser una cadena de texto.',
                'email.required' => 'El email es obligatrio.',
                'email.email' => 'El email debe ser una dirección de correo electrónico válida.',
            ];

            // Agregar la regla para 'rol' solo si el usuario no está editando su propio perfil
            if (!$esUsuarioPropio) {
                $rules['rol'] = 'required|in:administrador,profesor';
                $messages['rol.required'] = 'El rol es obligatrio.';
                $messages['rol.in'] = 'El rol debe ser profesor o administrador.';
            }

            $this->validate($request, $rules);

            // Actualizar usuario
            $usuario->nombre_completo = $request->nombre_completo;
            $usuario->email = $request->email;

            // Actualizar roles solo si no es el propio perfil del usuario
            if (!$esUsuarioPropio) {
                $usuario->syncRoles([$request->rol]);
            }

            $usuario->save();

            return redirect()->route('usuarios.index')->with('success', 'Usuario modificado correctamente.');
        } catch (Exception $e) {

            //Cancelamos la transacion
            DB::rollBack();

            return redirect()->route('usuarios.edit', compact('usuario'))->withErrors($e->getMessage())->withInput();
        }
    }



    /**
     * Elimina el usuario pasado por parametro de la base de datos.
     * Este método no se va a usar pero lo dejamos hecho por si en futuras actulizacioones es necesario.
     * En caso de querer ser utilizado habría que borrar las incidecnias creadas por el usuario.
     *
     * @param App\Models\User
     * @return Illuminate\Routing\Redirector::route Redirije a una ruta u otra dependiendo del resultado de la operación
     */
    public function destroy(User $usuario)
    {
        /*
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
        */
        abort('404');
    }
}
