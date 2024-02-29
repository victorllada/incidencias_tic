@extends('layouts.plantilla')
@section('titulo', 'Incidencias - show')
@section('archivosJS')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
@endsection
@section('contenido')

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
                    <li class="breadcrumb-item"><a href="{{ route('incidencias.index', $incidencia) }}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Incidencia {{ $incidencia->id }}</li>
                </ol>
            </nav>

            {{-- Boton para exportar en los distitos formatos --}}
            <div class="dropdown custom-dropdown">
                <button class="btn aquamarine-400 text-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Exportar
                </button>
                <ul class="dropdown-menu custom-dropdown-menu">
                    <li><a class="dropdown-item" href="#">PDF</a></li>
                    <li><a class="dropdown-item" href="#">EXCEL</a></li>
                    <li><a class="dropdown-item" href="#">CSV</a></li>
                </ul>
            </div>
        </div>
        {{-- Información de la incidencia --}}
        <div class="card mb-5 aquamarine-100">

            {{-- Encabezado del la tarjeta --}}
            <div class="card-header p-2">
                <h4 class="card-title">Detalles de la Incidencia</h4>
            </div>

            {{-- Cuerpo de la tarjeta --}}
            <div class="card-body">
                {{-- Fila id --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Id:</span> {{ $incidencia->id }}
                    </div>
                </div>

                {{-- Fila tipo, sub-tipo y sub-sub-tipo --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Tipo:</span> {{ $incidencia->tipo }}
                    </div>

                    <!-- Si no hay sub-tipos de incidencias no se muestra -->
                    @isset($incidencia->subtipo->subtipo_nombre)
                        <div class="col-lg-4">
                            <span class="fw-bolder">Subtipo:</span> {{ $incidencia->subtipo->subtipo_nombre }}
                        </div>
                    @endisset

                    <!-- Si no hay sub-sub-tipos de incidencias no se muestra -->
                    @isset($incidencia->subtipo->sub_subtipo)
                        <div class="col-lg-4">
                            <span class="fw-bolder">Subsubtipo:</span> {{ $incidencia->subtipo->sub_subtipo }}
                        </div>
                    @endisset
                </div>

                {{-- Fila creador, fecha creacion y fecha cierre --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Creador:</span>
                        {{ $incidencia->creador->nombre_completo }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Fecha de creación:</span> {{ $incidencia->fecha_creacion }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Fecha de cierre:</span> {{ $incidencia->fecha_cierre }}
                    </div>
                </div>

                {{-- Fila estado,  prioridad y duracion --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Estado:</span> {{ $incidencia->estado }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Prioridad:</span> {{ $incidencia->prioridad }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Duración:</span> {{ $incidencia->duracion }}
                    </div>
                </div>

                {{-- Fila equipo --}}
                <div class="row mb-4">
                    <!-- Si el equipo no es null mostramos sus datos, en caso contrario mostramos mensaje -->
                    <div class="col">
                        @empty($incidencia->equipo)
                            <span class="fw-bolder">Equipo:</span> No hay equipo asignado
                        @else
                            <span class="fw-bolder">Equipo:</span>
                            {{ $incidencia->equipo->tipo_equipo . ' ' . $incidencia->equipo->marca . ' ' . $incidencia->equipo->modelo }}
                        @endempty
                    </div>
                </div>

                <hr>

                {{-- Fila descripcion y actuaciones --}}
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <span class="fw-bolder">Descripción:</span>
                        <textarea class="form-control" rows="8" readonly>{{ $incidencia->descripcion }}</textarea>
                    </div>
                    <div class="col-lg-6">
                        <span class="fw-bolder">Actuaciones:</span>
                        <textarea class="form-control" rows="8" readonly>{{ $incidencia->actuaciones }}</textarea>
                    </div>
                </div>

                {{-- Fila archivo y responsable --}}
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <span class="fw-bolder">Archivo adjunto:</span> {{ $incidencia->adjunto_url }}
                    </div>

                    <!-- Si responsable no es null, muestra sus atributos nombre y apellidos, si es null muestra mensaje -->
                    <div class="col-lg-6">
                        @empty($incidencia->responsables)
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
                        <a href="{{ route('incidencias.edit', $incidencia) }}" type="button"
                            class="btn aquamarine-400 text-white">Editar</a>
                        <form action="{{ route('incidencias.destroy', $incidencia) }}" method="POST">
                            @csrf
                            @method("delete")
                            <button type="submit" class="btn aquamarine-400 text-white">Borrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
