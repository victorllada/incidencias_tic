@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Inicio')
@section('contenido')

    {{-- Botones de exportar --}}
    <div class="container d-flex justify-content-end align-items-center mb-5 gap-2 overflow-visible">
        <div>Exportar a:</div>
        <button type="button" class="btn aquamarine-400">PDF</button>
        <button type="button" class="btn aquamarine-400">EXCEL</button>
        <button type="button" class="btn aquamarine-400">CSV</button>
    </div>

    <nav class="navbar bg-body-tertiary" aria-label="Light offcanvas navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Light offcanvas navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbarLight"
                aria-controls="offcanvasNavbarLight" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbarLight"
                aria-labelledby="offcanvasNavbarLightLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLightLabel">Offcanvas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex mt-3" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container text-left">

        {{-- Encabezado de la lista de incidencias --}}
        <div class="row mb-4">
            <div
                class="col fw-bolder border rounded-start p-3 aquamarine-400 d-flex justify-content-between align-items-center gap-2">
                <input type="text" placeholder="Usuario" class="filtros aquamarine-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-search" viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
            </div>
            <div class="col fw-bolder border p-3 aquamarine-400">
                <select name="" id="" class="filtros aquamarine-400">
                    <option value="">Tipo</option>
                </select>
            </div>
            <div class="col fw-bolder border p-3 aquamarine-400">
                <select name="" id="" class="filtros aquamarine-400">
                    <option value="">Subtipo</option>
                </select>
            </div>
            <div class="col fw-bolder border p-3 aquamarine-400 d-flex justify-content-between align-items-center gap-2">
                <input type="text" placeholder="Descripción" class="filtros aquamarine-400">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-search" viewBox="0 0 16 16">
                    <path
                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
            </div>
            <div class="col fw-bolder border p-3 aquamarine-400">
                <select name="" id="" class="filtros aquamarine-400">
                    <option value="">Prioridad</option>
                </select>
            </div>
            <div class="col fw-bolder border rounded-end p-3 aquamarine-400">
                <select name="" id="" class="filtros aquamarine-400">
                    <option value="">Estado</option>
                </select>
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
@endsection
