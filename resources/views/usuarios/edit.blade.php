@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Usuarios - Edit')
@section('archivosJS')
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/incidencias.js'])
@endsection
@section('contenido')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center gap-3 mb-5">
            {{-- Migas de pan --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('usuarios.index', $usuario) }}">Administrar usuarios</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <span>{{ $usuario->nombre_completo }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                Hubo errores al rellenar el formulario:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!--Falta añadir la ruta del store en el atributo action del form-->
        <form action="{{ route('usuarios.update', $usuario) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card mb-5 aquamarine-100">
                <div class="card-header p-2">
                    <h4 class="card-title">Datos de {{ $usuario->nombre_completo }}</h4>
                </div>

                <div class="card-body">

                    {{-- Fila 1 tipo sub-tipo y sub-sub-tipo --}}
                    <div class="row mb-4">
                        <div class="col-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="nombre_completo">
                                    Usuario
                                </label>
                                <input type="text" class="form-control" name="nombre_completo" id="nombre_completo"
                                    value="{{ $usuario->nombre_completo }}">
                            </div>
                        </div>
                    </div>

                    {{-- Fila 2  name y email --}}
                    <div class="row mb-4" id="div-equipo">
                        <div class="col-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="name">
                                    Nombre
                                </label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $usuario->name }}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="email">
                                    Email
                                </label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ $usuario->email }}">
                            </div>
                        </div>
                    </div>

                    {{-- Fila 3 departamento y rol --}}
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="departamento">
                                    Departamento
                                </label>
                                <select class="form-select" name="departamento" id="departamento" required>
                                    <option selected disabled value="-1">Selecciona el departamento</option>
                                    <option value="BAJA" {{ $usuario->prioridad == 'BAJA' ? 'selected' : '' }}>
                                        Baja
                                    </option>
                                    <option value="MEDIA" {{ $usuario->prioridad == 'MEDIA' ? 'selected' : '' }}>
                                        Media
                                    </option>
                                    <option value="ALTA" {{ $usuario->prioridad == 'ALTA' ? 'selected' : '' }}>
                                        Alta
                                    </option>
                                    <option value="URGENTE"{{ $usuario->prioridad == 'URGENTE' ? 'selected' : '' }}>
                                        Urgente
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="rol">
                                    Rol
                                </label>
                                <select class="form-select" name="rol" id="rol" required>
                                    <option selected disabled value="-1">Selecciona el rol</option>
                                    <option value="BAJA" {{ $usuario->prioridad == 'BAJA' ? 'selected' : '' }}>
                                        Baja
                                    </option>
                                    <option value="MEDIA" {{ $usuario->prioridad == 'MEDIA' ? 'selected' : '' }}>
                                        Media
                                    </option>
                                    <option value="ALTA" {{ $usuario->prioridad == 'ALTA' ? 'selected' : '' }}>
                                        Alta
                                    </option>
                                    <option value="URGENTE"{{ $usuario->prioridad == 'URGENTE' ? 'selected' : '' }}>
                                        Urgente
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Boton para editar el usuario --}}
                    <div class="row mt-5">
                        <div class="col">
                            <input type="submit" class="btn aquamarine-400 text-white" value="Actualizar">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
