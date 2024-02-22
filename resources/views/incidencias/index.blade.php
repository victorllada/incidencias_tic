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
        <div class="row sticky-top mb-2">
            <div class="col fw-bolder border rounded-start p-3 aquamarine-400">Usuario</div>
            <div class="col fw-bolder border p-3 aquamarine-400">Tipo</div>
            <div class="col fw-bolder border p-3 aquamarine-400">Subtipo</div>
            <div class="col fw-bolder border p-3 aquamarine-400">Descripción</div>
            <div class="col fw-bolder border rounded-end p-3 aquamarine-400">Estado</div>
        </div>

        {{-- Lista de incidencias --}}
        @forelse ($incidencias as $incidencia)
            <div class=" row lista-incidencias mb-4">
                <a href="{{ route('incidencias.show', $incidencia) }}">
                    <div class="row justify-content-between flex-nowrap rounded">
                        <div class="col border rounded-start p-3">
                            {{ $incidencia->creador->nombre }}
                            {{ $incidencia->creador->apellido1 }}
                            {{ $incidencia->creador->apellido2 }}
                        </div>
                        <div class="col border p-3">
                            {{ $incidencia->tipo }}</div>
                        <div class=" col border p-3">
                            {{ $incidencia->subtipo_id }}
                        </div>
                        <div class="col border p-3">
                            {{ $incidencia->descripcion }}</div>
                        <div class="col border rounded-end p-3">
                            {{ $incidencia->estado }}
                        </div>
                    </div>
                </a>
            </div>
        @empty
            <p>No hay incidencias que mostrar.</p>
        @endforelse
    </div>
@endsection
