@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Inicio')
@section('contenido')

    <div class="container">

        {{-- Contenedor del boton filtrar y los botones exportar --}}
        <div class="d-flex justify-content-between align-items-center gap-3 mb-5">

            {{-- Boton y desplegable para los filtros --}}
            <div class="navbar bg-body-tertiary px-0" aria-label="Light offcanvas navbar">
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

                    {{-- Desplegable con los filtros --}}
                    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbarLight"
                        aria-labelledby="offcanvasNavbarLightLabel">
                        <div class="offcanvas-header">
                            <h5 class="offcanvas-title" id="offcanvasNavbarLightLabel">Opciones de filtrado</h5>

                            {{-- Boton para cerrar el desplegable --}}
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>

                        {{-- Contendor con los filtros y boton de filtrado --}}
                        <div class="offcanvas-body d-flex flex-column justify-between gap-4">

                            {{-- Filtro usuario --}}
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200" for="idFiltro">ID</label>
                                <input class="form-control" id="idFiltro" name="idFiltro" type="search"
                                    placeholder="Introduce el ID">
                            </div>

                            {{-- Filtro usuario --}}
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200" for="nombreFiltro">Usuario</label>
                                <input class="form-control" id="nombreFiltro" name="nombreFiltro" type="search"
                                    placeholder="Introduce nombre del usuario">
                            </div>

                            {{-- Filtro tipo --}}
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200" for="tipoFiltro">Tipo</label>
                                <select class="form-select" id="tipoFiltro" name="tipoFiltro">
                                    <option selected value="-1">Selecciona el tipo</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            {{-- Filtro subtipo --}}
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200" for="subtipoFiltro">Subtipo</label>
                                <select class="form-select" id="subtipoFiltro" name="subtipoFiltro">
                                    <option selected value="-1">Selecciona el subtipo</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            {{-- Filtro descripción --}}
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200" for="descripcionFiltro">Descripción</label>
                                <input class="form-control" id="descripcionFiltro" name="descripcionFiltro" type="search"
                                    placeholder="Introduce la descripción">
                            </div>

                            {{-- Filtro prioridad --}}
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200" for="prioridadFiltro">Prioridad</label>
                                <select class="form-select" id="prioridadFiltro" name="prioridadFiltro">
                                    <option selected value="-1">Selecciona la prioridad</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            {{-- Filtro fecha desde hasta --}}
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200" for="fechaDesdeFiltro">Fecha</label>
                                <input class="form-control" type="date" id="fechaDesdeFiltro" name="fechaDesdeFiltro"
                                    aria-label="Desde">
                                <label class="" for="fechaHastaFiltro"></label>
                                <input class="form-control" type="date" id="fechaHastaFiltro" name="fechaHastaFiltro"
                                    aria-label="Hasta">
                            </div>

                            {{-- Filtro estado --}}
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200" for="estadoFiltro">Estado</label>
                                <select class="form-select" id="estadoFiltro" name="estadoFiltro">
                                    <option selected>Selecciona el estado</option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>

                            {{-- Boton de filtrado y borrar filtros --}}
                            <div class="d-flex justify-content-between gap-2">
                                <button class="btn aquamarine-400" type="submit">Borrar
                                    filtros</button>{{-- Boton de filtrado --}}
                                <button class="btn aquamarine-400 flex-fill" type="submit"
                                    data-bs-dismiss="offcanvas">Filtrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botones exportar --}}
            <div class="d-flex align-items-center gap-2">
                <div>Exportar a:</div>
                <button type="button" class="btn aquamarine-400">PDF</button>
                <button type="button" class="btn aquamarine-400">EXCEL</button>
                <button type="button" class="btn aquamarine-400">CSV</button>
            </div>
        </div>

        {{-- Contenedor para el encabezado de y todas las incidencias --}}
        <div class="container text-left mb-5">

            {{-- Encabezado de la lista de incidencias --}}
            <div class="row d-flex justify-content-between flex-nowrap text-white aquamarine-400">
                <div class="col fw-bolder p-3">
                    ID
                </div>
                <div class="col fw-bolder p-3">
                    Usuario
                </div>
                <div class="col fw-bolder p-3">
                    Tipo
                </div>
                <div class="col fw-bolder p-3">
                    Subtipo
                </div>
                <div class="col fw-bolder p-3">
                    Fecha de creación
                </div>
                <div class="col fw-bolder p-3">
                    Descripción
                </div>
                <div class="col fw-bolder p-3">
                    Prioridad
                </div>
                <div class="col fw-bolder p-3">
                    Estado
                </div>
            </div>

            {{-- Lista de incidencias --}}
            <div class="mb-6">
                @forelse ($incidencias as $incidencia)
                    <div class="row lista-incidencias">
                        <a href="{{ route('incidencias.show', $incidencia) }}">
                            <div class="row d-flex justify-content-between flex-nowrap rounded">
                                <div class="col p-3">
                                    {{ $incidencia->id }}
                                </div>
                                <div class="col p-3">
                                    {{ $incidencia->creador->nombre }}
                                    {{ $incidencia->creador->apellido1 }}
                                    {{ $incidencia->creador->apellido2 }}
                                </div>
                                <div class="col p-3">
                                    {{ $incidencia->tipo }}
                                </div>
                                <div class="col p-3">
                                    {{ $incidencia->subtipo_id }}
                                </div>
                                <div class="col p-3">
                                    {{ $incidencia->fecha_creacion }}
                                </div>
                                <div class="col p-3 text-ellipsis">
                                    {{ $incidencia->descripcion }}
                                </div>
                                <div class="col p-3">
                                    {{ $incidencia->prioridad }}
                                </div>
                                <div class="col p-3">
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
