@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Usuarios - Detalles')
@section('archivosJS')
    @vite(['resources/js/app.js'])
@endsection
@section('contenido')

    <!--Esta vista no se usa actualmente, pero lo dejamos hecho por si en futuras actualizaciones de la aplicación se necesita-->

    <h1>Usuarios Show</h1>

    <div>
        <div class="d-flex justify-content-between align-items-center gap-3 mb-5">
            {{-- Migas de pan --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('usuarios.index', $usuario) }}">Administrar usuarios</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $usuario->nombre_completo }}</li>
                </ol>
            </nav>
        </div>

        {{-- Información de la incidencia --}}
        <div class="card mb-5 aquamarine-100">

            {{-- Encabezado del la tarjeta --}}
            <div class="card-header p-2">
                <h4 class="card-title">Detalles del usuario</h4>
            </div>

            {{-- Cuerpo de la tarjeta --}}
            <div class="card-body">
                {{-- Fila id --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Id:</span> {{ $usuario->id }}
                    </div>
                </div>

                {{-- Fila nombre --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Nombre:</span> {{ $usuario->name }}
                    </div>

                    <div class="col-lg-4">
                        <span class="fw-bolder">Nombre completo: </span> {{ $usuario->nombre_completo }}
                    </div>
                </div>

                {{-- Botones actilizar y borrar incidencia --}}
                <div class="row mt-5">
                    <div class="d-flex gap-2">
                        <a href="{{ route('usuarios.edit', $usuario) }}" type="button"
                            class="btn aquamarine-400 text-white">Editar</a>
                        <button type="button" class="btn aquamarine-400 text-white">Borrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
