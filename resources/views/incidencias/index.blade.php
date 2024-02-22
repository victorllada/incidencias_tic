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
    <div class="container text-left mb-4">
        <div class="row aquamarine-400 border rounded-top sticky-top">
            <div class="col bolder fw-bolder p-3">Id</div>
            <div class="col border fw-bolder p-3">Tipo</div>
            <div class="col bolder fw-bolder p-3">Subtipo</div>
            <div class="col border fw-bolder p-3">Descripción</div>
            <div class="col border fw-bolder p-3">Estado</div>
        </div>

        {{-- Lista de incidencias --}}
        @forelse ($incidencias as $incidencia)
            <div class=" row lista-incidencias">
                <a href="{{ route('incidencias.show', $incidencia) }}">
                    <div class="row justify-content-between flex-nowrap">
                        <div class="col border p-3">Id:{{ $incidencia->id }}</div>
                        <div class="col border p-3">Tipo:{{ $incidencia->tipo }}</div>
                        <div class=" col border p-3">Subtipo:{{ $incidencia->subtipo_id }}
                        </div>
                        <div class="col border p-3">
                            Descripción:{{ $incidencia->descripcion }}</div>
                        <div class="col border p-3">
                            Estado:{{ $incidencia->estado }}
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p>No hay incidencias que mostrar.</p>
        @endforelse
    </div>
@endsection
