@extends('layouts.plantilla')
@section('titulo', 'Incidencias - show')
@section('contenido')

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
        <div class="card-body fs-5">

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
                @isset($incidencia->subtipo->sub_subtipo)
                    <div class="col-lg-4">
                        <span class="fw-bolder">Subsubtipo:</span> {{ $incidencia->subtipo->sub_subtipo }}
                    </div>
                @endisset
            </div>

            <div class="row mb-4">
                <div class="col-lg-4">
                    <span class="fw-bolder">Creador:</span>
                    {{ $incidencia->creador->nombre . ' ' . $incidencia->creador->apellido1 . ' ' . $incidencia->creador->apellido2 }}
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
                <div class="col-lg-6">
                    @empty($incidencia->responsable)
                        <span class="fw-bolder">Responsable:</span> Aún no se ha asignado
                    @else
                        <span class="fw-bolder">Responsable:</span>
                        @empty($incidencia->responsable->nombre || $incidencia->responsable->apellido1 || $incidencia->responsable->apellido2)
                            Información de responsable incompleta
                        @else
                            {{ $incidencia->responsable->nombre . ' ' . $incidencia->responsable->apellido1 . ' ' . $incidencia->responsable->apellido2 }}
                        @endempty
                    @endempty
                </div>
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
        </div>
    </div>
@endsection
