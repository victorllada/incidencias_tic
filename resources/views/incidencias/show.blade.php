@extends('layouts.plantilla')
@section('titulo', 'Incidencias - show')
@section('contenido')

    {{-- Migas de pan --}}
    <div class="fs-3 mb-4">
        <a href="{{ route('incidencias.index', $incidencia) }}">Inicio</a> -> Incidencia {{ $incidencia->id }}
    </div>
    <div class="fs-5 mb-5">
        <div class="row p-3 aquamarine-100">
            <div class="col ">Id: {{ $incidencia->id }}</div>
        </div>
        <div class="row p-3 aquamarine-100"">
            <div class="col">Tipo: {{ $incidencia->tipo }}</div>
            <div class="col">Subtipo: {{ $incidencia->subtipo->subtipo_nombre }}</div>

            <!--Si no hay sub-sub-tipos de incidencias no se muestra-->
            @if (optional($incidencia->subtipo)->sub_subtipo)
                <div class="col">Subsubtipo: {{ $incidencia->subtipo->sub_subtipo }}</div>
            @endif

        </div>
        <div class="row">
            <div class="col aquamarine-100">Fecha de creación: {{ $incidencia->fecha_creacion }}</div>
            <div class="col aquamarine-100">Fecha de cierre: {{ $incidencia->fecha_cierre }}</div>
        </div>
        <div class="row">
            <div class="col aquamarine-100">Estado: {{ $incidencia->estado }}</div>
            <div class="col aquamarine-100">Prioridad: {{ $incidencia->prioridad }}</div>
        </div>
        <div class="row">
            <textarea name="" id="" cols="30" rows="10" class="col">{{ $incidencia->descripcion }}</textarea>
            <textarea name="" id="" cols="30" rows="10" class="col">{{ $incidencia->actuaciones }}</textarea>
        </div>

        <ul class="list-group">
            <li class="list-group-item aquamarine-100">Duración: {{ $incidencia->duracion }}</li>
            <li class="list-group-item aquamarine-100">Archivo adjunto: {{ $incidencia->adjunto_url }}</li>
            <li class="list-group-item aquamarine-100">Creador:
                {{ $incidencia->creador->nombre . ' ' . $incidencia->creador->apellido1 . ' ' . $incidencia->creador->apellido2 }}
            </li>
            <!--Si responsable no es null, muestra sus atributos nombre y apellidos, si es null muestra mensaje-->
            @if ($incidencia->responsable != null)
                <li class="list-group-item aquamarine-100">Responsable:
                    <!--Si el nombre o los apellidos es null ponemos info incompleta, en caso contrario lo mostramos-->
                    @if (
                        $incidencia->responsable->nombre != null &&
                            $incidencia->responsable->apellido1 != null &&
                            $incidencia->responsable->apellido2 != null)
                        {{ $incidencia->responsable->nombre . ' ' . $incidencia->responsable->apellido1 . ' ' . $incidencia->responsable->apellido2 }}
                    @else
                        Información de responsable incompleta
                    @endif
                </li>
            @else
                <li class="list-group-item aquamarine-100">Responsable: Aún no se ha asignado</li>
            @endif

            <!--Si el equipo no es null mostramos sus datos, en caso contrario mostramos mensaje-->
            @if ($incidencia->equipo != null)
                <li class="list-group-item aquamarine-100">
                    Equipo:
                    {{ $incidencia->equipo->tipo_equipo . ' ' . $incidencia->equipo->marca . ' ' . $incidencia->equipo->modelo }}
                </li>
            @else
                <li class="list-group-item aquamarine-100">Equipo: No hay equipo asignado</li>
            @endif

            <li class="list-group-item aquamarine-100">Creador el día: {{ $incidencia->created_at }}</li>
            <li class="list-group-item aquamarine-100">Actualizado el día: {{ $incidencia->updated_at }}</li>
        </ul>
    </div>
@endsection
