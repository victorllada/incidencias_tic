@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Usuarios - Inicio')
@section('archivosJS')
    @vite(['resources/js/app.js', 'resources/js/usuarios.js'])
@endsection
@section('contenido')

    <div>
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
                                    <label class="col-5 input-group-text aquamarine-200" for="nombreUsuarioFiltro">
                                        Usuario
                                    </label>
                                    <input class="form-control" id="nombreUsuarioFiltro" name="nombreUsuarioFiltro"
                                        type="search" placeholder="Introduce el usuario">
                                </div>

                                {{-- Filtro nombre completo --}}
                                <div class="input-group">
                                    <label class="col-5 input-group-text aquamarine-200" for="nombreCompletoFiltro">
                                        Nombre completo
                                    </label>
                                    <input class="form-control" id="nombreCompletoFiltro" name="nombreCompletoFiltro"
                                        type="search" placeholder="Introduce nombre completo">
                                </div>

                                {{-- Filtro email --}}
                                <div class="input-group">
                                    <label class="col-5 input-group-text aquamarine-200" for="emailFiltro">
                                        Email
                                    </label>
                                    <input class="form-control" id="emailFiltro" name="emailFiltro" type="search"
                                        placeholder="example@mail.com">
                                </div>

                                {{-- Filtro departamento --}}
                                <div class="input-group">
                                    <label class="col-5 input-group-text aquamarine-200" for="departamentoFiltro">
                                        Departamento
                                    </label>
                                    <select class="form-select" id="departamentoFiltro" name="departamentoFiltro">
                                        <option selected value="-1">Selecciona departamento</option>
                                        @foreach ($departamentos as $departamento)
                                            <option value={{$departamento->nombre}}>{{$departamento->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- Filtro rol --}}
                                <div class="input-group">
                                    <label class="col-5 input-group-text aquamarine-200" for="rolFiltro">
                                        Rol
                                    </label>
                                    <select class="form-select" id="rolFiltro" name="rolFiltro">

                                        <option selected value="-1">Selecciona el rol</option>
                                        <option value="administrador">Administrador</option>
                                        <option value="profesor">Profesor</option>

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
            </div>
        </div>

        {{-- Contenedor para el encabezado de y todas las incidencias --}}
        <div class="container text-left mb-5">

            {{-- Encabezado de la lista de incidencias --}}
            <div class="row d-flex justify-content-between flex-nowrap text-white aquamarine-300 rounded-top">
                <div class="col fw-bolder p-3">
                    Usuario
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

            {{-- Lista de usuarios --}}
            <div class="row mb-6" id="contenedorUsuarios">

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
                        ¿Desea borrar el usuario: <span id="numeroID"></span>?{{-- Nombre complreto del usuarios --}}
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
