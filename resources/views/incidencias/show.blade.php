@extends('layouts.plantilla')
@section('titulo', 'Incidencias - show')
@section('contenido')

    {{-- Migas de pan --}}
    <div class="fs-3 mb-4">
        <a href="{{ route('incidencias.index', $incidencia) }}">Inicio</a> -> Incidencia {{ $incidencia->id }}
    </div>

    <ul class="list-group fs-5 mb-4">
        <li class="list-group-item aquamarine-200"">Id: {{ $incidencia->id }}</li>
        <li class="list-group-item aquamarine-200"">Tipo: {{ $incidencia->tipo }}</li>
        <li class="list-group-item aquamarine-200"">Subtipo: {{ $incidencia->subtipo_id }}</li>
        <li class="list-group-item aquamarine-200"">Fecha de creación: {{ $incidencia->fecha_creacion }}</li>
        <li class="list-group-item aquamarine-200"">Fecha de cierre: {{ $incidencia->fecha_cierre }}</li>
        <li class="list-group-item aquamarine-200"">Duración: {{ $incidencia->duracion }}</li>
        <li class="list-group-item aquamarine-200"">Descripción: {{ $incidencia->descripcion }}</li>
        <li class="list-group-item aquamarine-200"">Actuaciones: {{ $incidencia->actuaciones }}</li>
        <li class="list-group-item aquamarine-200"">Estado: {{ $incidencia->estado }}</li>
        <li class="list-group-item aquamarine-200"">Prioridad: {{ $incidencia->prioridad }}</li>
        <li class="list-group-item aquamarine-200"">Estado: {{ $incidencia->adjunto_url }}</li>
        <li class="list-group-item aquamarine-200"">Estado: {{ $incidencia->creador->nombre }}</li>
        <li class="list-group-item aquamarine-200"">Estado: {{ $incidencia->responsable }}</li>
        <li class="list-group-item aquamarine-200"">Estado: {{ $incidencia->equipo }}</li>
        <li class="list-group-item aquamarine-200"">Estado: {{ $incidencia->created_at }}</li>
        <li class="list-group-item aquamarine-200"">Estado: {{ $incidencia->updated_at }}</li>
    </ul>
@endsection
