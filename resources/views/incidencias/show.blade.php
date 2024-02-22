@extends('layouts.plantilla')
@section('titulo', 'Incidencias - show')
@section('contenido')

    {{-- Migas de pan --}}
    <div class="fs-3">
        <a href="{{ route('incidencias.index', $incidencia) }}">Inicio</a> -> Incidencia {{ $incidencia->id }}
    </div>

    <div>
        <ul>
            <li>Id:{{ $incidencia->id }}</li>
            <li>Tipo:{{ $incidencia->tipo }}</li>
            <li>Subtipo:{{ $incidencia->subtipo_id }}</li>
            <li>Descripción:{{ $incidencia->descripcion }}</li>
            <li>Estado:{{ $incidencia->estado }}</li>
            <li>Estado:{{ $incidencia->estado }}</li>
        </ul>
    </div>
@endsection
