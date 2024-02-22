@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Inicio')
@section('contenido')

    <div class="d-flex justify-content-end align-items-center mb-5 gap-2">
        <div>Exportar a:</div>
        <button type="button" class="btn aquamarine-400">PDF</button>
        <button type="button" class="btn aquamarine-400">EXCEL</button>
        <button type="button" class="btn aquamarine-400">CSV</button>
    </div>
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
