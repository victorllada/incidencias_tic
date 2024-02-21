@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Inicio')
@section('contenido')

    <h1>Incidencias index</h1>
    @forelse ($incidencias as $incidencia)
        <div>
            <a href="{{ route('incidencias.show', $incidencia) }}">
                <ul>
                    <li>Id:{{ $incidencia->id }}</li>
                    <li>Tipo:{{ $incidencia->tipo }}</li>
                    <li>Subtipo:{{ $incidencia->subtipo_id }}</li>
                    <li>Descripción:{{ $incidencia->descripcion }}</li>
                    <li>Estado:{{ $incidencia->estado }}</li>
                </ul>
            </a>
        </div>
    @empty
        <p>No hay incidencias que mostrar.</p>
    @endforelse
@endsection
