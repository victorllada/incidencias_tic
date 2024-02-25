@extends('layouts.plantilla')
@section('titulo', 'Incidencias - show')
@section('contenido')

    <div class="container">

        {{-- Migas de pan --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('incidencias.index', $incidencia) }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Incidencia {{ $incidencia->id }}</li>
            </ol>
        </nav>

        {{-- Información de la incidencia --}}
        <div class="card mb-5 aquamarine-100">
            <div class="card-header p-2">
                <h4 class="card-title">Detalles de la Incidencia</h4>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Id:</span> {{ $incidencia->id }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Tipo:</span> {{ $incidencia->tipo }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Subtipo:</span> {{ $incidencia->subtipo->subtipo_nombre }}
                    </div>

                    <!-- Si no hay sub-sub-tipos de incidencias no se muestra -->
                    @isset($incidencia->subtipo->sub_subtipo)
                        <div class="col-lg-4">
                            <span class="fw-bolder">Subsubtipo:</span> {{ $incidencia->subtipo->sub_subtipo }}
                        </div>
                    @endisset
                </div>

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

                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Estado:</span> {{ $incidencia->estado }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Prioridad:</span> {{ $incidencia->prioridad }}
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-4">
                        @empty($incidencia->equipo)
                            <span class="fw-bolder">Equipo:</span> No hay equipo asignado
                        @else
                            <span class="fw-bolder">Equipo:</span>
                            {{ $incidencia->equipo->tipo_equipo . ' ' . $incidencia->equipo->marca . ' ' . $incidencia->equipo->modelo }}
                        @endempty
                    </div>
                </div>

                <hr>

                <div class="row mb-3">
                    <div class="col-lg-6">
                        <span class="fw-bolder">Archivo adjunto:</span> {{ $incidencia->adjunto_url }}
                    </div>
                    <!-- Si responsable no es null, muestra sus atributos nombre y apellidos, si es null muestra mensaje -->
                    @empty($incidencia->responsables)
                        <div class="col-lg-6">
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
                        </div>
                    @endempty
                </div>

                <div class="row">
                    <!-- Si el equipo no es null mostramos sus datos, en caso contrario mostramos mensaje -->
                    @empty($incidencia->equipo)
                        <li class="list-group-item aquamarine-100">Equipo: No hay equipo asignado</li>
                    @else
                        <li class="list-group-item aquamarine-100">
                            Equipo:
                            {{ $incidencia->equipo->tipo_equipo . ' ' . $incidencia->equipo->marca . ' ' . $incidencia->equipo->modelo }}
                        </li>
                    @endempty
                </div>

                <div class="row mb-3">
                    <div class="col-lg-6">
                        <span class="fw-bolder">Descripción:</span>
                        <textarea class="form-control" rows="8">{{ $incidencia->descripcion }}</textarea>
                    </div>
                    <div class="col-lg-6">
                        <span class="fw-bolder">Actuaciones:</span>
                        <textarea class="form-control" rows="8">{{ $incidencia->actuaciones }}</textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Duración:</span> {{ $incidencia->duracion }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Creado el día:</span> {{ $incidencia->created_at }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Actualizado el día:</span>{{ $incidencia->updated_at }}
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-1">
                        <button type="button" class="btn aquamarine-400 text-white">Actulizar</button>
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn aquamarine-400 text-white">Borrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
