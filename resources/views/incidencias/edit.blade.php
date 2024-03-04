@extends('layouts.plantilla')
@section('titulo', 'Editar')
@section('archivosJS')
    @vite(['resources/js/app.js', 'resources/js/editIncidencia.js'])
@endsection
@section('contenido')

    <div>
        <div class="d-flex justify-content-between align-items-center gap-3 mb-5">
            {{-- Migas de pan --}}
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('incidencias.index', $incidencia) }}">Inicio</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        <a href="{{ route('incidencias.show', $incidencia) }}">Incidencia {{ $incidencia->id }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <span>Actualizar datos</span>
                    </li>
                </ol>
            </nav>
        </div>

        <form action="{{ route('incidencias.update', $incidencia) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card mb-5 aquamarine-100">
                <div class="card-header p-2">
                    <h4 class="card-title">Datos de la Incidencia</h4>
                </div>

                <div class="card-body">

                    {{-- Fila 1 tipo sub-tipo y sub-sub-tipo --}}
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="tipo">Tipo</label>
                                <select class="form-select" name="tipo" id="tipo" required>
                                    <option disabled value="-1">Selecciona el tipo</option>
                                    <option value="CUENTAS" {{ $incidencia->tipo == 'CUENTAS' ? 'selected' : '' }}>CUENTAS
                                    </option>
                                    <option value="EQUIPOS" {{ $incidencia->tipo == 'EQUIPOS' ? 'selected' : '' }}>EQUIPOS
                                    </option>
                                    <option value="WIFI" {{ $incidencia->tipo == 'WIFI' ? 'selected' : '' }}>WIFI</option>
                                    <option value="INTERNET" {{ $incidencia->tipo == 'INTERNET' ? 'selected' : '' }}>
                                        INTERNET</option>
                                    <option value="SOFTWARE" {{ $incidencia->tipo == 'SOFTWARE' ? 'selected' : '' }}>
                                        SOFTWARE</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" id="div-sub-tipo">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="subTipo">Sub-tipo</label>
                                <select class="form-select" name="subTipo" id="subTipo">
                                    <option selected disabled value="-1">Selecciona el sub-tipo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" id="div-sub-sub-tipo">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder"
                                    for="subSubTipo">Sub-sub-tipo</label>
                                <select class="form-select" name="subSubTipo" id="subSubTipo">
                                    <option selected disabled value="-1">Selecciona el sub-sub-tipo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Fila 2  en caso de que el tipo sea equipos --}}
                    <div class="row mb-4" id="divEquipo" hidden>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="aula">
                                    Aula</label>
                                <select class="form-select" name="aula" id="aula" required>
                                    <!--onchange="cargarEtiquetas()"-->
                                    <option selected disabled value="-1">Selecciona el aula</option>
                                    @foreach ($aulas as $aula)
                                        <option value="{{ $aula->id }}"
                                            {{ $aula->id == optional($incidencia->equipo)->aula_id ? 'selected' : '' }}>
                                            {{ $aula->codigo }}
                                        </option>
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
                                    @foreach ($etiquetas as $etiqueta)
                                        <option value="{{ $etiqueta->etiqueta }}"
                                            {{ $etiqueta->etiqueta == optional($incidencia->equipo)->etiqueta ? 'selected' : '' }}>
                                            {{ $etiqueta->etiqueta }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Fila 3 prioridad, estado y duracion --}}
                    <div class="row mb-4">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="prioridad">Prioridad</label>
                                <select class="form-select" name="prioridad" id="prioridad" required>
                                    <option selected disabled value="-1">Selecciona la prioridad</option>
                                    <option value="BAJA" {{ $incidencia->prioridad == 'BAJA' ? 'selected' : '' }}>
                                        Baja
                                    </option>
                                    <option value="MEDIA" {{ $incidencia->prioridad == 'MEDIA' ? 'selected' : '' }}>
                                        Media
                                    </option>
                                    <option value="ALTA" {{ $incidencia->prioridad == 'ALTA' ? 'selected' : '' }}>
                                        Alta
                                    </option>
                                    <option value="URGENTE"{{ $incidencia->prioridad == 'URGENTE' ? 'selected' : '' }}>
                                        Urgente
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="estado">Estado</label>
                                <select class="form-select" name="estado" id="estado" required>
                                    <option selected value="-1">Selecciona el estado</option>
                                    <option value="ABIERTA" {{ $incidencia->estado == 'ABIERTA' ? 'selected' : '' }}>
                                        Abierta
                                    </option>
                                    <option value="CERRADA"{{ $incidencia->estado == 'CERRADA' ? 'selected' : '' }}>
                                        Cerrada
                                    </option>
                                    <option value="RESUELTA"{{ $incidencia->estado == 'RESUELTA' ? 'selected' : '' }}>
                                        Resuelta
                                    </option>
                                    <option value="ASIGNADA"{{ $incidencia->estado == 'ASIGNADA' ? 'selected' : '' }}>
                                        Asignada
                                    </option>
                                    <option
                                        value="ENVIADA A INFORTEC"{{ $incidencia->estado == 'ENVIADA A INFORTEC' ? 'selected' : '' }}>
                                        Enviada a Infortec
                                    </option>
                                    <option value="EN PROCESO" {{ $incidencia->estado == 'EN PROCESO' ? 'selected' : '' }}>
                                        En proceso
                                    </option>
                                </select>
                            </div>
                        </div>
                        @role('administrador')
                            <div class="col-lg-4" id="div-duracion">
                                <div class="input-group">
                                    <label class="input-group-text aquamarine-200 fw-bolder" for="duracion">
                                        Duración
                                    </label>
                                    <input type="number" class="form-control" name="duracion" id="duracion"
                                        placeholder="60" pattern="[0-9]*" value="{{ $incidencia->duracion }}">
                                </div>
                            </div>
                        @endrole
                    </div>

                    {{-- Fila 4 descripción y actuaciones --}}
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder"
                                    for="descripcion">Descripción</label>
                                <textarea class="form-control" placeholder="Deja aqui tus comentarios" name="descripcion" id="descripcion"
                                    rows="8" maxlength="256" required>{{ $incidencia->descripcion }}</textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder"
                                    for="actuaciones">Actuaciones</label>
                                <textarea class="form-control" placeholder="Deja aqui las actuaciones" name="actuaciones" id="actuaciones"
                                    rows="8" maxlength="256"
                                    @role('profesor')
                                    readonly
                                    @endrole>{{ $incidencia->actuaciones }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Archivo adjunto --}}
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="archivo">
                                    Archivo
                                </label>
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
                            <div class="col input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="asignado">Asignado</label>
                                <div class="d-flex flex-wrap gap-4 form-control ">
                                    @forelse ($usuarios as $usuario)
                                        <div>
                                            <input class="form-check-input" type="radio" name="asignado"
                                                value="{{ $usuario->id }}"
                                                {{ $usuario->id == $incidencia->responsable_id ? 'checked' : '' }}>
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

                    {{-- Boton para editar incidencia --}}
                    <div class="row mt-5">
                        <div class="col">
                            <button type="button" class="btn aquamarine-400 text-white"data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Actualización de datos</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que quieres guardar los cambios?
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-secondary" data-bs-dismiss="modal" value="Cancelar">
                            <input type="submit" class="btn aquamarine-400 text-white" value="Actualizar">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
