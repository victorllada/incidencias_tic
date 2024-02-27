@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Inicio')
@section('contenido')

    <div class="container">

        {{-- Contenedor del boton filtrar y los botones exportar --}}
        <div class="d-flex justify-content-between align-items-center gap-3 mb-5">
            <div class="d-flex justify-content-between gap-2">

                {{-- Boton y desplegable para los filtros --}}
                <div class="navbar bg-body-tertiary py-0" aria-label="Light offcanvas navbar">
                    <div>
                        <button class="btn aquamarine-400 text-white" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbarLight" aria-controls="offcanvasNavbarLight"
                            aria-label="Toggle navigation">Filtrar
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

                                {{-- Filtro id --}}
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
                                        <option value="EQUIPOS">Equipos</option>
                                        <option value="CUENTAS">Cuentas</option>
                                        <option value="WIFI">Wifi</option>
                                        <option value="INTERNET">Internet</option>
                                        <option value="SOFTWARE">Software</option>
                                    </select>
                                </div>

                                {{-- Filtro subtipo --}}
                                <div class="input-group">
                                    <label class="input-group-text aquamarine-200" for="subtipoFiltro">Subtipo</label>
                                    <select class="form-select" id="subtipoFiltro" name="subtipoFiltro">
                                        <option selected value="-1">Selecciona el subtipo</option>
                                    </select>
                                </div>

                                {{-- Filtro prioridad --}}
                                <div class="input-group">
                                    <label class="input-group-text aquamarine-200" for="prioridadFiltro">Prioridad</label>
                                    <select class="form-select" id="prioridadFiltro" name="prioridadFiltro">
                                        <option selected value="-1">Selecciona la prioridad</option>
                                        <option value="baja">Baja</option>
                                        <option value="urgente">Urgente</option>
                                        <option value="media">Media</option>
                                        <option value="alta">Alta</option>
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
                                        <option selected value="-1">Selecciona el estado</option>
                                        <option value="abierta">Abierta</option>
                                        <option value="cerrada">Cerrada</option>
                                        <option value="resuelta">Resuelta</option>
                                        <option value="asignada">Asignada</option>
                                        <option value="enviada a infortec">Enviada a Infortec</option>
                                        <option value="en proceso">En proceso</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Boton de filtrado y borrar filtros --}}
                            <div class="d-flex justify-content-between gap-2">
                                <button class="btn aquamarine-400 text-white" type="submit" id="borrar">Borrar
                                    filtros</button>
                                <button class="btn aquamarine-400 text-white flex-fill" type="submit"
                                    data-bs-dismiss="offcanvas" id="filtrar">Filtrar</button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Boton crear incidencia --}}
                <a class=" btn aquamarine-400 text-white" type="button" href="{{ route('incidencias.create') }}">Crear
                    incidencia
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-plus-lg" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                    </svg>
                </a>
            </div>

            {{-- Botones --}}
            <div class="d-flex align-items-center gap-2">

                {{-- Boton para exportar en los distitos formatos --}}
                <div class="dropdown custom-dropdown">
                    <button class="btn aquamarine-400 text-white dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Exportar
                    </button>
                    <ul class="dropdown-menu custom-dropdown-menu">
                        <li><a class="dropdown-item" href="#">PDF</a></li>
                        <li><a class="dropdown-item" href="#">EXCEL</a></li>
                        <li><a class="dropdown-item" href="#">CSV</a></li>
                    </ul>
                </div>

                {{-- @role('administrador') --}}
                {{-- Boton y desplegabale de informes --}}
                <div class="navbar bg-body-tertiary py-0" aria-label="Light offcanvas navbar">
                    <div>
                        <button class="btn aquamarine-400 text-white" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbarLight2" aria-controls="offcanvasNavbarLight2"
                            aria-label="Toggle navigation">Informes
                        </button>

                        {{-- Desplegable con informes --}}
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbarLight2"
                            aria-labelledby="offcanvasNavbarLightLabel2">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasNavbarLightLabel">Tipos de informes</h5>

                                {{-- Boton para cerrar el desplegable --}}
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>

                            {{-- Contendor con tipos de informes --}}
                            <div class="offcanvas-body d-flex flex-column justify-between gap-4">


                            </div>
                        </div>
                    </div>
                </div>
                {{-- @endrole --}}
            </div>
        </div>

        {{-- Contenedor para el encabezado de y todas las incidencias --}}
        <div class="container text-left mb-5">

            {{-- Encabezado de la lista de incidencias --}}
            <div class="row d-flex justify-content-between flex-nowrap text-white aquamarine-300">
                <div class="col fw-bolder p-3 baja-res">
                    ID
                </div>
                <div class="col fw-bolder p-3 baja-res">
                    Usuario
                </div>
                <div class="col fw-bolder p-3">
                    Tipo
                </div>
                <div class="col fw-bolder p-3">
                    Subtipo
                </div>
                <div class="col fw-bolder p-3 baja-res">
                    Fecha de creación
                </div>
                <div class="col fw-bolder p-3">
                    Prioridad
                </div>
                <div class="col fw-bolder p-3">
                    Estado
                </div>
                <div class="col fw-bolder p-3 movil-res">
                </div>
            </div>

            {{-- <a href="{{ route('incidencias.show', $incidencia) }}"></a> --}}
            {{-- Lista de incidencias --}}
            <div class="row mb-6" id="contenedorIncidencias">
                @forelse ($incidencias as $incidencia)
                    <div class="lista-incidencias">
                        <div class="row d-flex justify-content-between align-items-center flex-nowrap rounded">
                            <div class="col p-3 baja-res"
                                onclick="redirect('{{ route('incidencias.show', $incidencia) }}')">
                                {{ $incidencia->id }}
                            </div>
                            <div class="col p-3 baja-res"
                                onclick="redirect('{{ route('incidencias.show', $incidencia) }}')">
                                {{ $incidencia->creador->nombre_completo }}
                            </div>
                            <div class="col p-3 text-ellipsis"
                                onclick="redirect('{{ route('incidencias.show', $incidencia) }}')">
                                {{ $incidencia->tipo }}
                            </div>
                            <div class="col p-3 text-ellipsis"
                                onclick="redirect('{{ route('incidencias.show', $incidencia) }}')">
                                {{ $incidencia->subtipo->subtipo_nombre }}
                            </div>
                            <div class="col p-3 baja-res"
                                onclick="redirect('{{ route('incidencias.show', $incidencia) }}')">
                                {{ $incidencia->fecha_creacion }}
                            </div>
                            <div class="col p-3 text-ellipsis"
                                onclick="redirect('{{ route('incidencias.show', $incidencia) }}')">
                                {{ $incidencia->prioridad }}
                            </div>
                            <div class="col p-3 text-ellipsis"
                                onclick="redirect('{{ route('incidencias.show', $incidencia) }}')">
                                {{ $incidencia->estado }}
                            </div>
                            <div class="col p-3 movil-res">
                                <div class="d-flex flex-column justify-content-center gap-2">
                                    <a class=" btn aquamarine-400 text-white" type="button"
                                        href="{{ route('incidencias.show', $incidencia) }}">Detalles</a>
                                    <form action="" class="d-flex">
                                        <input type="button" class="btn aquamarine-400 text-white flex-fill"
                                            value="Borrar" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No hay incidencias que mostrar.</p>
                @endforelse
            </div>
        </div>

        {{-- Paginacion --}}
        <nav aria-label="Page navigation">
            <ul class="pagination  d-flex justify-content-center">
                <li class="page-item"><a class="page-link" href="#">Inicio</a></li>
                <li class="page-item"><a class="page-link" href="#">Anterior</a></li>
                <li class="page-item"><input type="number"></li>
                <li class="page-item"><button class="page-link" href="#">Siguiente</button></li>
                <li class="page-item"><button class="page-link" href="#">Final</button></li>
            </ul>
        </nav>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Petición de borrado</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Desea borrar la incidencia
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Cancelar">
                        <input type="button" class="btn btn-danger" value="Borrar" id="actibarBorrado"
                            name="activarBorrado">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
