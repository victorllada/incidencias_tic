<?php

use App\Http\Controllers\IncidenciaController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Inicio
Route::get('/', InicioController::class)->name('inicio');

// Exportaciones
Route::get('incidencias/exportar/estadisticas/{formato}', [IncidenciaController::class, 'exportarEstadisticasTiposIncidencias'])->name('incidencias.exportar.estadisticas')->middleware('auth');
Route::get('incidencias/exportar/{tipo}/{formato}', [IncidenciaController::class, 'exportarIncidencias'])->name('incidencias.exportar')->middleware('auth');

//Ruta para descargar el archivo adjunto a cada incidencia
Route::get('descargar/{id}', [IncidenciaController::class, 'descargarArchivo'])->name('descargar.archivo')->middleware('auth');;

//Incidencias
Route::resource('incidencias', IncidenciaController::class)->parameters([
    'incidencias' => 'incidencia'
])->middleware('auth');

//Ruta para obtener las etiquetas de cada aula
Route::get('/obtener-etiquetas/{aulaId}', [IncidenciaController::class, 'obtenerEtiquetas'])->middleware('auth');;

//Ruta para poder enviar el json de incidencias
Route::get("/datos",[IncidenciaController::class,"datosIncidencias"])->middleware('auth');

//Ruta para poder enviar el json de usuarios
Route::get("/datosUsuarios",[UserController::class,"datosUsuarios"])->middleware('auth');

//Usuarios
Route::resource('usuarios', UserController::class)->parameters([
    'usuarios' => 'usuario'
])->middleware(['auth', 'role:administrador']);

/*Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});*/

/*Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/
