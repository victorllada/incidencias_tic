@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Inicio')
@section('contenido')

    <h1>Incidencias index</h1>
    @forelse ($incidencias as $incidencia)
        <div class="mb-4 lista-incidencias">
            <a href="{{ route('incidencias.show', $incidencia) }}">
                <div class="row flex-nowrap">
                    <div class="col border rounded-start-2 p-3">Id:{{ $incidencia->id }}</div>
                    <div class="col border border-start-0 p-3">Tipo:{{ $incidencia->tipo }}</div>
                    <div class="col border border-start-0 p-3">Subtipo:{{ $incidencia->subtipo_id }}</div>
                    <div class="col col-6 border border-start-0 p-3">Descripción:{{ $incidencia->descripcion }}</div>
                    <div class="col border border-start-0 rounded-end-2 p-3">Estado:{{ $incidencia->estado }}</div>
                </div>
            </a>
        </div>
    @empty
        <p>No hay incidencias que mostrar.</p>
    @endforelse
@endsection
