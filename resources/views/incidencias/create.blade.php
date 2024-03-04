@extends('layouts.plantilla')
@section('titulo', 'Crear')
@section('archivosJS')
    @vite(['resources/js/app.js', 'resources/js/createIncidencias.js'])
@endsection
@section('contenido')

    <div>

        {{-- Migas de pan --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('incidencias.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear incidencia</li>
            </ol>
        </nav>

        <!--Falta añadir la ruta del store en el atributo action del form-->
        <form action="{{ route('incidencias.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card mb-5 aquamarine-100">
                <div class="card-header p-2">
                    <h4 class="card-title">Datos de la Incidencia</h4>
                </div>

                <div class="card-body">

                    {{-- Fila 1 nombre y departemento --}}
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="nombre">Nombre</label>
                                <input type="text" class="form-control" name="nombre" id="nombre"
                                    value="{{ auth()->user()->nombre_completo }}" readonly>
                            </div>
                        </div>
                        @empty(auth()->user()->id_departamento || auth()->user()->nombre_departamento)
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <label class="input-group-text aquamarine-200 fw-bolder"
                                        for="departamento">Departamento</label>
                                    <select class="form-select" name="departamento" id="departamento" required>
                                        <option selected disabled value="-1">Selecciona el departamento</option>
                                        @foreach ($departamentos as $departamento)
                                            <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endempty
                        @empty(auth()->user()->email)
                            <div class="col-lg-4">
                                <div class="input-group">
                                    <label class="input-group-text aquamarine-200 fw-bolder" for="email">Email</label>
                                    <input class="form-control" id="email" name="email" type="search"
                                        placeholder="Introduce tu email">
                                </div>
                            </div>
                        @endempty
                    </div>

                    {{-- Fila 2 tipo sub-tipo y sub-sub-tipo --}}
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="tipo">Tipo</label>
                                <select class="form-select" name="tipo" id="tipo" required>
                                    <option selected disabled value="-1">Selecciona el tipo</option>
                                    <option value="CUENTAS">Cuentas</option>
                                    <option value="EQUIPOS">Equipos</option>
                                    <option value="WIFI">Wifi</option>
                                    <option value="INTERNET">Internet</option>
                                    <option value="SOFTWARE">Software</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" id="div-sub-tipo" hidden>
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="sub-tipo">Sub-tipo</label>
                                <select class="form-select" name="sub-tipo" id="sub-tipo">
                                    <option selected disabled value="-1">Selecciona el sub-tipo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" id="div-sub-sub-tipo" hidden>
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder"
                                    for="sub-sub-tipo">Sub-sub-tipo</label>
                                <select class="form-select" name="sub-sub-tipo" id="sub-sub-tipo">
                                    <option selected disabled value="-1">Selecciona el sub-sub-tipo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Fila 3  en caso de que el tipo sea equipos --}}
                    <div class="row mb-4" id="div-equipo" hidden>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="aula">
                                    Aula</label>
                                <select class="form-select" name="aula" id="aula"
                                    required><!--onchange="cargarEtiquetas()"-->
                                    <option selected disabled value="-1">Selecciona el aula</option>
                                    @foreach ($aulas as $aula)
                                        <option value={{ $aula->id }}>{{ $aula->codigo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="num_etiqueta">Número de
                                    etiqueta</label>
                                <select class="form-select" name="num_etiqueta" id="num_etiqueta" required>
                                    <option selected disabled value="-1">Selecciona la etiqueta</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Fila 4 prioridad --}}
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="prioridad">Prioridad</label>
                                <select class="form-select" name="prioridad" id="prioridad" required>
                                    <option selected disabled value="-1">Selecciona la prioridad</option>
                                    <option value="BAJA">Baja</option>
                                    <option value="MEDIA">Media</option>
                                    <option value="ALTA">Alta</option>
                                    <option value="URGENTE">Urgente</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Fila 4 descripción y archivo --}}
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder"
                                    for="descripcion">Descripción</label>
                                <textarea class="form-control" placeholder="Deja aqui la descripción" name="descripcion" id="floatingTextarea"
                                    rows="8" maxlength="256">{{ old('descripcion') }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="archivo">Archivo</label>
                                <label for="fichero" class="form-label" hidden>Choose file</label>
                                <input type="file" class="form-control custom-file-input rounded-end" id="fichero"
                                    name="fichero">
                                <label class="custom-file-label" for="fichero" hidden>Select file</label>
                            </div>
                        </div>
                    </div>

                    {{-- Aqui se generara un checklist con los administradores --}}
                    @role('administrador')
                        <div class="row mb-4">
                            <div class="col-lg input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="asignado">Asignado</label>
                                <div class="d-flex flex-wrap gap-4 form-control ">
                                    @forelse ($usuarios as $usuario)
                                        <div>
                                            <input class="form-check-input" type="radio" name="asignado"
                                                value={{ $usuario->id }}>
                                            <label class="form-check-label"
                                                for="asignado">{{ $usuario->nombre_completo }}</label>
                                        </div>
                                    @empty
                                        <div>No hay usuarios</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endrole

                    {{-- Boton para crear incidencia --}}
                    <div class="row mt-5">
                        <div class="col">
                            <input type="submit" class="btn aquamarine-400 text-white" value="Crear incidencia">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
