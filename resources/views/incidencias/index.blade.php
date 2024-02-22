@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Inicio')
@section('contenido')

    <div class="container">
        {{-- Contenedor del boton filtrar y los botones exportar --}}
        <div class="d-flex justify-content-between align-items-center mb-5">

            {{-- Boton y desplegable para los filtros --}}
            <nav class="navbar bg-body-tertiary px-0" aria-label="Light offcanvas navbar">
                <div>
                    <button class="btn aquamarine-400" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasNavbarLight" aria-controls="offcanvasNavbarLight"
                        aria-label="Toggle navigation py-2">Filtrar
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-filter" viewBox="0 0 16 16">
                            <path
                                d="M6 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                        </svg>
                    </button>

                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbarLight"
                        aria-labelledby="offcanvasNavbarLightLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLightLabel">Opciones de filtrado</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body d-flex flex-column justify-between gap-4">
                            <div class="input-group">
                                <label class="input-group-text" for="inputGroupSelect01">Usuario</label>
                                <input class="form-control" type="search" placeholder="Introduce nombre del usuario">
                            </div>
                            <div class="input-group">
                                <label class="input-group-text" for="inputGroupSelect01">Tipo</label>
                                <select class="form-select" id="inputGroupSelect01">
                                    <option selected>Selecciona el tipo</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label class="input-group-text" for="inputGroupSelect01">Subtipo</label>
                                <select class="form-select" id="inputGroupSelect01">
                                    <option selected>Selecciona el subtipo</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label class="input-group-text" for="inputGroupSelect01">Descripción</label>
                                <input class="form-control" type="search" placeholder="Introduce la descripción">
                            </div>
                            <div class="input-group">
                                <label class="input-group-text" for="inputGroupSelect01">Prioridad</label>
                                <select class="form-select" id="inputGroupSelect01">
                                    <option selected>Selecciona la prioridad</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label class="input-group-text" for="inputGroupSelect01">Estado</label>
                                <select class="form-select" id="inputGroupSelect01">
                                    <option selected>Selecciona el estado</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                            <button class="btn aquamarine-400" type="submit" data-bs-dismiss="offcanvas"
                                aria-label="Close">Filtrar</button>
                        </div>
                    </div>
                </div>
            </nav>

            {{-- Botones exportar --}}
            <div class="d-flex align-items-center gap-2">
                <div>Exportar a:</div>
                <button type="button" class="btn aquamarine-400">PDF</button>
                <button type="button" class="btn aquamarine-400">EXCEL</button>
                <button type="button" class="btn aquamarine-400">CSV</button>
            </div>
        </div>

        {{-- Contenedor para el encabezado de y todas las incidencias --}}
        <div class="container text-left">

            {{-- Encabezado de la lista de incidencias --}}
            <div class="row mb-4">
                <div
                    class="col fw-bolder border rounded-start p-3 aquamarine-400 d-flex justify-content-between align-items-center gap-2">
                    Usuario
                </div>
                <div class="col fw-bolder border p-3 aquamarine-400">
                    Tipo
                </div>
                <div class="col fw-bolder border p-3 aquamarine-400">
                    Subtipo
                </div>
                <div
                    class="col fw-bolder border p-3 aquamarine-400 d-flex justify-content-between align-items-center gap-2">
                    Descripción
                </div>
                <div class="col fw-bolder border p-3 aquamarine-400">
                    Prioridad
                </div>
                <div class="col fw-bolder border rounded-end p-3 aquamarine-400">
                    Estado
                </div>
            </div>

            {{-- Lista de incidencias --}}
            <div class="mb-6">
                @forelse ($incidencias as $incidencia)
                    <div class="row lista-incidencias mb-4">
                        <a href="{{ route('incidencias.show', $incidencia) }}">
                            <div class="row justify-content-between flex-nowrap rounded">
                                <div class="col border rounded-start p-3">
                                    {{ $incidencia->creador->nombre }}
                                    {{ $incidencia->creador->apellido1 }}
                                    {{ $incidencia->creador->apellido2 }}
                                </div>
                                <div class="col border p-3">
                                    {{ $incidencia->tipo }}
                                </div>
                                <div class=" col border p-3">
                                    {{ $incidencia->subtipo_id }}
                                </div>
                                <div class="col border p-3">
                                    {{ $incidencia->descripcion }}
                                </div>
                                <div class="col border p-3">
                                    {{ $incidencia->prioridad }}
                                </div>
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
        </div>
    </div>
@endsection
