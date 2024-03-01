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
Route::get('incidencias/exportar/estadistcas/{formato}', [IncidenciaController::class, 'exportarEstadisticasTiposIncidencias'])->name('incidencias.exportar.estadisticas')->middleware('auth');
Route::get('incidencias/exportar/{tipo}/{formato}', [IncidenciaController::class, 'exportarIncidencias'])->name('incidencias.exportar')->middleware('auth');

//Incidencias
Route::resource('incidencias', IncidenciaController::class)->parameters([
    'incidencias' => 'incidencia'
])->middleware('auth');

//ruta para poder enviar el json de incidencias
Route::get("/datos",[IncidenciaController::class,"datosIncidencias"])->middleware('auth');

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
