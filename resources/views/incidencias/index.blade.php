@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Inicio')
@section('contenido')

    {{-- Botones de exportar --}}
    <div class="d-flex justify-content-end align-items-center mb-5 gap-2">
        <div>Exportar a:</div>
        <button type="button" class="btn aquamarine-400">PDF</button>
        <button type="button" class="btn aquamarine-400">EXCEL</button>
        <button type="button" class="btn aquamarine-400">CSV</button>
    </div>

    {{-- Encabezado de la lista de incidencias --}}
    <div>
        <div class="d-flex justify-content-between flex-nowrap aquamarine-400 border rounded-top">
            <div class="col border rounded-start-2 p-3">Id</div>
            <div class="col border border-start-0 p-3">Tipo</div>
            <div class="col border border-start-0 p-3">Subtipo</div>
            <div class="col col-6 border border-start-0 p-3">Descripción</div>
            <div class="col border border-start-0 rounded-end-2 p-3">Estado</div>
        </div>

        {{-- Lista de incidencias --}}
        @forelse ($incidencias as $incidencia)
            <div class="mb-4 lista-incidencias">
                <a href="{{ route('incidencias.show', $incidencia) }}">
                    <ul class="list-group list-group-horizontal">
                        <li class="list-group-item col border  p-3">Id:{{ $incidencia->id }}</li>
                        <li class="list-group-item col border border-start-0 p-3">Tipo:{{ $incidencia->tipo }}</li>
                        <li class="list-group-item col border border-start-0 p-3">Subtipo:{{ $incidencia->subtipo_id }}</li>
                        <li class="list-group-item col col-6 border border-start-0 p-3">
                            Descripción:{{ $incidencia->descripcion }}</li>
                        <li class="list-group-item col border border-start-0 rounded-end-2 p-3">
                            Estado:{{ $incidencia->estado }}
                        </li>
                    </ul>
                </a>
            </div>
        @empty
            <p>No hay incidencias que mostrar.</p>
        @endforelse
    </div>
@endsection
