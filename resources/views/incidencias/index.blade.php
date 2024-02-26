@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Inicio')
@section('contenido')

    <div class="container">

        {{-- Contenedor del boton filtrar y los botones exportar --}}
        <div class="d-flex justify-content-between align-items-center gap-3 mb-5">

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
                                    <option value="quia">quia</option>
                                    <option value="recusandae">recusandae</option>
                                    <option value="tenetur">Three</option>
                                    <option value="magni">magni</option>
                                    <option value="ut">recusandae</option>
                                    <option value="deleniti">deleniti</option>
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

            {{-- Botones --}}
            <div class="d-flex align-items-center gap-2">

                {{-- Boton crear incidencia --}}
                <a class=" btn aquamarine-400 text-white" type="button" href="{{ route('incidencias.create') }}">Crear
                    incidencia</a>

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
                <div class="col fw-bolder p-3 baja-res">
                    Descripción
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
                            <div class="col p-3 text-ellipsis baja-res"
                                onclick="redirect('{{ route('incidencias.show', $incidencia) }}')">
                                {{ $incidencia->descripcion }}
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
                                    <a class=" btn aquamarine-400 text-white" type="button" href="#">Borrar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p>No hay incidencias que mostrar.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
<script>
    function redirect(url) {
        window.location.href = url;
    }
</script>
{{--
                    <div class="col p-3 d-flex justify-content-center align-items-center">
                        <button type="button" class="btn aquamarine-400 text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path
                                    d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                            </svg>
                        </button>
                    </div> --}}
