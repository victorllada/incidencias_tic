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
                        <textarea class="form-control" rows="8">{{ $incidencia->descripcion }}</textarea>
                    </div>
                    <div class="col-lg-6">
                        <span class="fw-bolder">Actuaciones:</span>
                        <textarea class="form-control" rows="8">{{ $incidencia->actuaciones }}</textarea>
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

                {{-- Fila creado el dia y actualizado el dia --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Creado el día:</span> {{ $incidencia->created_at }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Actualizado el día:</span>{{ $incidencia->updated_at }}
                    </div>
                </div>

                {{-- Botones actilizar y borrar incidencia --}}
                <div class="row">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn aquamarine-400 text-white">Actualizar</button>
                        <button type="button" class="btn aquamarine-400 text-white">Borrar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
