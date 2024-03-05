@extends('layouts.plantilla')
@section('titulo', 'Usuarios - Crear')
@section('archivosJS')
    @vite(['resources/js/app.js'])
@endsection
@section('contenido')

    <!--Esta vista no se usa actualmente, pero lo dejamos hecho por si en futuras actualizaciones de la aplicación se necesita-->

    <div>

        {{-- Migas de pan --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('incidencias.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear incidencia</li>
            </ol>
        </nav>

        <!--Falta añadir la ruta del store en el atributo action del form-->
        <form action="{{ route('incidencias.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card mb-5 aquamarine-100">
                <div class="card-header p-2">
                    <h4 class="card-title">Datos del usuario</h4>
                </div>

                <div class="card-body">

                    {{-- Fila 1  --}}
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="nombre_completo">
                                    Nombre
                                </label>
                                <input type="text" class="form-control" name="nombre_completo" id="nombre_completo">
                            </div>
                        </div>
                    </div>

                    {{-- Fila 2  name y email --}}
                    <div class="row mb-4" id="div-equipo">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="name">
                                    Usuario
                                </label>
                                <input type="text" class="form-control" name="name" id="name">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="email">
                                    Email
                                </label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>
                        </div>
                    </div>

                    {{-- Fila 3 departamento y rol --}}
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="rol">
                                    Rol
                                </label>
                                <select class="form-select" name="rol" id="rol" required>
                                    @foreach ($rolesDisponibles as $rol)
                                        <option value="{{ $rol }}">{{ $rol }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder"
                                    for="departamento">Departamento</label>
                                <select class="form-select" name="departamento" id="departamento" required>
                                    <option selected disabled value="-1">Selecciona el departamento</option>
                                    @foreach ($departamentos as $departamento)
                                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Boton para crear el usuario --}}
                    <div class="row mt-5">
                        <div class="col">
                            <input type="submit" class="btn aquamarine-400 text-white" value="Crear">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
