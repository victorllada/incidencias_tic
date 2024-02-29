@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Usuarios - Inicio')
@section('archivosJS')
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/incidencias.js'])
@endsection
@section('contenido')

    <h1>Usuarios</h1>

    <div class="container">

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

                                {{-- Filtro nombre --}}
                                <div class="input-group">
                                    <label class="col-3 input-group-text aquamarine-200" for="nombreFiltro">ID</label>
                                    <input class="form-control" id="nombreFiltro" name="nombreFiltro" type="search"
                                        placeholder="Introduce el nombre">
                                </div>

                                {{-- Filtro nombre completo --}}
                                <div class="input-group">
                                    <label class="col-3 input-group-text aquamarine-200" for="nombre_completoFiltro">
                                        Nombre completo
                                    </label>
                                    <input class="form-control" id="nombre_completoFiltro" name="nombre_completoFiltro"
                                        type="search" placeholder="Introduce nombre completo">
                                </div>

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

                {{-- Boton crear usuario --}}
                <a class=" btn aquamarine-400 text-white" type="button" href="{{ route('usuarios.create') }}">
                    Crear usuario
                    <i class="bi bi-plus-lg"></i>
                </a>
            </div>
        </div>

        {{-- Contenedor para el encabezado de y todas las incidencias --}}
        <div class="container text-left mb-5">

            {{-- Encabezado de la lista de incidencias --}}
            <div class="row d-flex justify-content-between flex-nowrap text-white aquamarine-300">
                <div class="col fw-bolder p-3">
                    Nombre
                </div>
                <div class="col fw-bolder p-3">
                    Nombre completo
                </div>
                <div class="col fw-bolder p-3">
                    Email
                </div>
                <div class="col fw-bolder p-3">
                    Departamento
                </div>
                <div class="col fw-bolder p-3">
                    Rol
                </div>
                <div class="col fw-bolder p-3 movil-res">
                </div>
            </div>

            {{-- <a href="{{ route('incidencias.show', $incidencia) }}"></a> --}}
            {{-- Lista de incidencias --}}
            <div class="row mb-6">
                @forelse ($usuarios as $usuario)
                    <div class="lista-incidencias">
                        <div class="row d-flex justify-content-between align-items-center flex-nowrap rounded">
                            <div class="col p-3 text-ellipsis"
                                onclick="redirect('{{ route('usuarios.show', $usuario) }}')">
                                {{ $usuario->name }}
                            </div>
                            <div class="col p-3 text-ellipsis"
                                onclick="redirect('{{ route('usuarios.show', $usuario) }}')">
                                {{ $usuario->nombre_completo }}
                            </div>
                            <div class="col p-3 text-ellipsis"
                                onclick="redirect('{{ route('usuarios.show', $usuario) }}')">
                                {{ $usuario->email }}
                            </div>
                            <div class="col p-3 text-ellipsis"
                                onclick="redirect('{{ route('usuarios.show', $usuario) }}')">
                                {{ $usuario->nombre_departamento }}
                            </div>
                            <div class="col p-3 text-ellipsis"
                                onclick="redirect('{{ route('usuarios.show', $usuario) }}')">
                                {{-- Aqui va el rol del usuario --}}
                            </div>
                            <div class="col p-3 movil-res">
                                <div class="d-flex flex-column justify-content-center gap-2">
                                    <a class=" btn aquamarine-400 text-white" type="button"
                                        href="{{ route('usuarios.edit', $usuario) }}">
                                        Editar
                                    </a>
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
        <ul class="pagination d-flex justify-content-center mb-5">
            <li class="page-item">
                <a class="page-link text-aquamarine-400" href="#" id="inicioPaginacion">Inicio</a>
            </li>
            <li class="page-item">
                <button class="page-link text-aquamarine-400" id="anterior">
                    <i class="bi bi-arrow-left"></i>
                </button>
            </li>
            <li class="page-item d-flex justify-content-center align-items-center numero-pagina border">
                <input type="text" id="paginaActual" value="1" class="text-aquamarine-400 input-numero"
                    size="1">
                <span id="paginasTotales" class="text-aquamarine-400"></span>
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
                        Desea borrar el usuario: <span id="numeroID"></span>{{-- Nombre complreto del usuarios --}}
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Cancelar">
                        <input type="button" class="btn btn-danger" value="Borrar" id="activarBorrado"
                            name="activarBorrado">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
