@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Inicio')
@section('archivosJS')
    @vite(['resources/js/app.js', 'resources/js/incidencias.js'])
@endsection
@section('contenido')

    <div>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                Hubo errores al rellenar el formulario:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Contenedor del boton filtrar y los botones exportar --}}
        <div class="d-flex justify-content-between align-items-center gap-3 mb-5">
            <div class="d-flex gap-2">

                {{-- Boton y desplegable para los filtros --}}
                <div class="navbar bg-body-tertiary py-0" aria-label="Light offcanvas navbar">
                    <div>
                        <button class="btn aquamarine-400 text-white" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbarLight" aria-controls="offcanvasNavbarLight"
                            aria-label="Toggle navigation">
                            Filtrar
                            <i class="bi bi-filter"></i>
                        </button>

                        {{-- Desplegable con los filtros --}}
                        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNavbarLight"
                            aria-labelledby="offcanvasNavbarLightLabel">
                            <div class="offcanvas-header mb-2">
                                <h5 class="offcanvas-title" id="offcanvasNavbarLightLabel">Opciones de filtrado</h5>

                                {{-- Boton para cerrar el desplegable --}}
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>

                            {{-- Contendor con los filtros y boton de filtrado --}}
                            <div class="offcanvas-body d-flex flex-column justify-between gap-4">

                                @role('administrador')
                                    {{-- Filtro id, solo lo ve los admins --}}
                                    <div class="input-group">
                                        <label class="col-3 input-group-text aquamarine-200" for="idFiltro">ID</label>
                                        <input class="form-control" id="idFiltro" name="idFiltro" type="search"
                                            placeholder="Introduce el ID">
                                    </div>
                                @endrole

                                @role('administrador')
                                    {{-- Filtro usuario, solo lo ve los admins --}}
                                    <div class="input-group">
                                        <label class="col-3 input-group-text aquamarine-200" for="nombreFiltro">Creador</label>
                                        <input class="form-control" id="nombreFiltro" name="nombreFiltro" type="search"
                                            placeholder="Introduce nombre del creador">
                                    </div>
                                @endrole

                                {{-- Filtro tipo --}}
                                <div class="input-group">
                                    <label class="col-3 input-group-text aquamarine-200" for="tipoFiltro">Tipo</label>
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
                                    <label class="col-3 input-group-text aquamarine-200" for="subtipoFiltro">Subtipo</label>
                                    <select class="form-select" id="subtipoFiltro" name="subtipoFiltro">
                                        <option selected value="-1">Selecciona el subtipo</option>
                                    </select>
                                </div>

                                {{-- Filtro prioridad --}}
                                <div class="input-group">
                                    <label class="col-3 input-group-text aquamarine-200"
                                        for="prioridadFiltro">Prioridad</label>
                                    <select class="form-select" id="prioridadFiltro" name="prioridadFiltro">
                                        <option selected value="-1">Selecciona la prioridad</option>
                                        <option value="BAJA">Baja</option>
                                        <option value="URGENTE">Urgente</option>
                                        <option value="MEDIA">Media</option>
                                        <option value="ALTA">Alta</option>
                                    </select>
                                </div>

                                {{-- Filtro fecha desde hasta --}}
                                <div class="input-group">
                                    <label class="col-3 input-group-text aquamarine-200"
                                        for="fechaDesdeFiltro">Fecha</label>
                                    <input class="form-control" type="date" id="fechaDesdeFiltro" name="fechaDesdeFiltro"
                                        aria-label="Desde">
                                    <label class="" for="fechaHastaFiltro"></label>
                                    <input class="form-control" type="date" id="fechaHastaFiltro" name="fechaHastaFiltro"
                                        aria-label="Hasta">
                                </div>

                                {{-- Filtro estado --}}
                                <div class="input-group">
                                    <label class="col-3 input-group-text aquamarine-200" for="estadoFiltro">Estado</label>
                                    <select class="form-select" id="estadoFiltro" name="estadoFiltro">
                                        <option selected value="-1">Selecciona el estado</option>
                                        <option value="ABIERTA">Abierta</option>
                                        <option value="CERRADA">Cerrada</option>
                                        <option value="RESUELTA">Resuelta</option>
                                        <option value="ASIGNADA">Asignada</option>
                                        <option value="ENVIADA A INFORTEC">Enviada a Infortec</option>
                                        <option value="EN PROCESO">En proceso</option>
                                    </select>
                                </div>

                                {{-- Filtro responsable --}}
                                <div class="input-group">
                                    <label class="col-3 input-group-text aquamarine-200"
                                        for="responsableFiltro">Responsable</label>
                                    <select class="form-select" id="responsableFiltro" name="responsableFiltro">
                                        <option selected value="-1">Selecciona un responsable</option>
                                        @foreach ($responsables as $responsable)
                                            <option value={{ $responsable->id }}>{{ $responsable->nombre_completo }}
                                            </option>
                                        @endforeach
                                    </select>
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
                </div>

                {{-- Boton crear incidencia --}}
                <a class=" btn aquamarine-400 text-white" type="button" href="{{ route('incidencias.create') }}">
                    Crear incidencia
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>

            {{-- Botones --}}
            <div class="d-flex gap-2">

                {{-- Boton para exportar en los distitos formatos --}}
                <div class="dropdown custom-dropdown">
                    <button class="btn aquamarine-400 text-white dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Exportar
                    </button>
                    <ul class="dropdown-menu custom-dropdown-menu">
                        <li><a class="dropdown-item"
                                href="{{ route('incidencias.exportar', ['tipo' => 'todas', 'formato' => 'pdf']) }}">PDF</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{ route('incidencias.exportar', ['tipo' => 'todas', 'formato' => 'xlsx']) }}">EXCEL</a>
                        </li>
                        <li><a class="dropdown-item"
                                href="{{ route('incidencias.exportar', ['tipo' => 'todas', 'formato' => 'csv']) }}">CSV</a>
                        </li>
                    </ul>
                </div>

                @role('administrador')
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
                                <div class="offcanvas-header mb-2">
                                    <h5 class="offcanvas-title" id="offcanvasNavbarLightLabel">Tipos de informes</h5>

                                    {{-- Boton para cerrar el desplegable --}}
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>
                                </div>

                                {{-- Contendor con tipos de informes --}}
                                <div class="offcanvas-body d-flex flex-column gap-5 pt-5">
                                    <div class="row">
                                        <div class="col-7 fw-bolder">Incidencias resueltas por cada administrador
                                        </div>
                                        <div class="col-5 d-flex gap-2 align-items-center px-0">
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'resueltas', 'formato' => 'pdf']) }}"
                                                class="button" data-tooltip="PDF">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-file-earmark-pdf"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'resueltas', 'formato' => 'xlsx']) }}"
                                                class="button" data-tooltip="EXCEL">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-file-earmark-excel"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'resueltas', 'formato' => 'csv']) }}"
                                                class="button" data-tooltip="CSV">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-filetype-csv"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-7 fw-bolder">Incidencias abiertas por cada usuario</div>
                                        <div class="col-5 d-flex gap-2 align-items-center px-0">
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'abiertas', 'formato' => 'pdf']) }}"
                                                class="button" data-tooltip="PDF">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-file-earmark-pdf"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'abiertas', 'formato' => 'xlsx']) }}"
                                                class="button" data-tooltip="EXCEL">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-file-earmark-excel"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'abiertas', 'formato' => 'csv']) }}"
                                                class="button" data-tooltip="CSV">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-filetype-csv"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-7 fw-bolder">Estadísticas sobre los tipos de incidencias</div>
                                        <div class="col-5 d-flex gap-2 align-items-center px-0">
                                            <a href="{{ route('incidencias.exportar.estadisticas', ['formato' => 'pdf']) }}"
                                                class="button" data-tooltip="PDF">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-file-earmark-pdf"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <a href="{{ route('incidencias.exportar.estadisticas', ['formato' => 'xlsx']) }}"
                                                class="button" data-tooltip="EXCEL">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-file-earmark-excel"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <a href="{{ route('incidencias.exportar.estadisticas', ['formato' => 'csv']) }}"
                                                class="button" data-tooltip="CSV">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-filetype-csv"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-7 fw-bolder">Tiempo dedicado a cada incidencia</div>
                                        <div class="col-5 d-flex gap-2 align-items-center px-0">
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'todasTiempoDedicado', 'formato' => 'pdf']) }}"
                                                class="button" data-tooltip="PDF">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-file-earmark-pdf"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'todasTiempoDedicado', 'formato' => 'xlsx']) }}"
                                                class="button" data-tooltip="EXCEL">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-file-earmark-excel"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'todasTiempoDedicado', 'formato' => 'csv']) }}"
                                                class="button" data-tooltip="CSV">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-filetype-csv"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-7 fw-bolder">Tiempos de resolución por tipo de incidencia</div>
                                        <div class="col-5 d-flex gap-2 align-items-center px-0">
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'resueltasTiempoPorTipo', 'formato' => 'pdf']) }}"
                                                class="button" data-tooltip="PDF">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-file-earmark-pdf"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'resueltasTiempoPorTipo', 'formato' => 'xlsx']) }}"
                                                class="button" data-tooltip="EXCEL">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-file-earmark-excel"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'resueltasTiempoPorTipo', 'formato' => 'csv']) }}"
                                                class="button" data-tooltip="CSV">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-filetype-csv"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-7 fw-bolder">Tiempo dedicado por cada administrador</div>
                                        <div class="col-5 d-flex gap-2 align-items-center px-0">
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'asignadas', 'formato' => 'pdf']) }}"
                                                class="button" data-tooltip="PDF">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-file-earmark-pdf"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'asignadas', 'formato' => 'xlsx']) }}"
                                                class="button" data-tooltip="EXCEL">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-file-earmark-excel"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                            <a href="{{ route('incidencias.exportar', ['tipo' => 'asignadas', 'formato' => 'csv']) }}"
                                                class="button" data-tooltip="CSV">
                                                <div class="button-wrapper">
                                                    <div class="text">
                                                        <i class="bi bi-filetype-csv"></i>
                                                    </div>
                                                    <span class="icon">
                                                        <i class="bi bi-download"></i>
                                                    </span>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endrole
            </div>
        </div>

        {{-- Contenedor para el encabezado de y todas las incidencias --}}
        <div class="container text-left mb-5">

            {{-- Encabezado de la lista de incidencias --}}
            <div class="row d-flex justify-content-between flex-nowrap text-white aquamarine-300 rounded-top">
                @role('administrador')
                    <div class="col fw-bolder p-3 baja-res">
                        ID
                    </div>
                @endrole
                @role('administrador')
                    <div class="col fw-bolder p-3 baja-res">
                        Creador
                    </div>
                @endrole
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
            <div class="row" id="contenedorIncidencias">
                {{-- @forelse ($incidencias as $incidencia)
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
                @endforelse --}}
            </div>
            <div class="row d-flex aquamarine-300 rounded-bottom">
                {{-- Paginacion --}}
                <div>
                    <ul class="pagination d-flex justify-content-center my-3">
                        <li class="page-item">
                            <a class="page-link text-aquamarine-400" href="#" id="inicioPaginacion">Inicio</a>
                        </li>
                        <li class="page-item">
                            <button class="page-link text-aquamarine-400" id="anterior">
                                <i class="bi bi-arrow-left"></i>
                            </button>
                        </li>
                        <li class="page-item d-flex justify-content-center align-items-center numero-pagina border">
                            <input type="text" id="paginaActual" value="1"
                                class="text-aquamarine-400 input-numero">
                            <span class="d-flex justify-content-center text-aquamarine-400">/</span>
                            <span id="paginasTotales" class="text-aquamarine-400 d-flex justify-content-center"></span>
                        </li>
                        <li class="page-item">
                            <button class="page-link text-aquamarine-400" id="siguiente">
                                <i class="bi bi-arrow-right"></i>
                            </button>
                        </li>
                        <li class="page-item">
                            <button class="page-link text-aquamarine-400" id="finalPaginacion">Final</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="graficas" class="d-flex flex-wrap justify-content-between gap-2 mb-5">
            <div id="graficaTipos" class="col border"></div>
            <div id="graficaTiempoMedio" class="col border"></div>
            <div id="graficaEstasdo" class="col border"></div>
        </div>

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
                        Desea borrar la incidencia con id: <span id="numeroID"></span>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Cancelar">
                        <form action="" id="formBorrado" method="POST">
                            @csrf
                            @method('delete')
                            <input type="submit" class="btn btn-danger" value="Borrar" id="activarBorrado"
                                name="activarBorrado">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
