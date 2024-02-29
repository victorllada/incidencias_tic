@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Usuarios - Show')
@section('archivosJS')
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/incidencias.js'])
@endsection
@section('contenido')

    <h1>Usuarios Show</h1>

    <div class="container">

        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif

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
                {{-- Fila Nombre --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Nombre completo:</span> {{ $usuario->nombre_completo }}
                    </div>
                </div>

                {{-- Fila --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Tipo:</span> {{ $usuario->email }}
                    </div>

                    <!-- Si no hay sub-tipos de usuario no se muestra -->
                    @isset($incidencia->subtipo->subtipo_nombre)
                        <div class="col-lg-4">
                            <span class="fw-bolder">Subtipo:</span> {{ $usuario->subtipo->subtipo_nombre }}
                        </div>
                    @endisset

                    <!-- Si no hay sub-sub-tipos de usuario no se muestra -->
                    @isset($incidencia->subtipo->sub_subtipo)
                        <div class="col-lg-4">
                            <span class="fw-bolder">Subsubtipo:</span> {{ $usuario->subtipo->sub_subtipo }}
                        </div>
                    @endisset
                </div>

                {{-- Fila  --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Departamento</span> {{ $usuario->nombre_departamento }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Fecha de cierre:</span> {{ $usuario }}
                    </div>
                </div>

                {{-- Fila --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Estado:</span> {{ $usuario }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Prioridad:</span> {{ $usuario }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Duración:</span> {{ $usuario }}
                    </div>
                </div>

                {{-- Fila --}}
                <div class="row mb-4">
                    <!-- Si el equipo no es null mostramos sus datos, en caso contrario mostramos mensaje -->
                    <div class="col">
                        @empty($usuario->equipo)
                            <span class="fw-bolder">Equipo:</span> No hay equipo asignado
                        @else
                            <span class="fw-bolder">Equipo:</span>
                            {{ $usuario->equipo->tipo_equipo . ' ' . $usuario->equipo->marca . ' ' . $usuario->equipo->modelo }}
                        @endempty
                    </div>
                </div>

                <hr>

                {{-- Fila  --}}
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <span class="fw-bolder">Descripción:</span>
                        <textarea class="form-control" rows="8" readonly>{{ $usuario->descripcion }}</textarea>
                    </div>
                    <div class="col-lg-6">
                        <span class="fw-bolder">Actuaciones:</span>
                        <textarea class="form-control" rows="8" readonly>{{ $usuario->actuaciones }}</textarea>
                    </div>
                </div>

                {{-- Fila --}}
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <span class="fw-bolder">Archivo adjunto:</span> {{ $usuario->adjunto_url }}
                    </div>

                    <!-- Si responsable no es null, muestra sus atributos nombre y apellidos, si es null muestra mensaje -->
                    <div class="col-lg-6">
                        @empty($usuario->responsables)
                            <span class="fw-bolder">Responsable:</span> Aún no se ha asignado
                        @else
                            <span class="fw-bolder">Responsable:</span>
                            <!-- Si el nombre o los apellidos es null ponemos info incompleta, en caso contrario lo mostramos -->
                            @empty($responsables)
                                Aún no hay responsables
                            @else
                                @foreach ($responsables as $responsable)
                                    <span>{{ $responsable->nombre_completo }} </span>
                                @endforeach
                            @endempty
                        @endempty
                    </div>
                </div>

                {{-- Botones actilizar y borrar incidencia --}}
                <div class="row">
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
