@extends('layouts.plantilla')
@section('titulo', 'Incidencias - show')
@section('archivosJS')
    @vite(['resources/js/app.js'])
@endsection
@section('contenido')

    <div>
        <div>

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    Hubo errores al mandar el mensaje:
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-between align-items-center gap-3 mb-5">
                {{-- Migas de pan --}}
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('incidencias.index', $incidencia) }}">Inicio</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Incidencia {{ $incidencia->id }}</li>
                    </ol>
                </nav>

                <div class="d-flex gap-2">
                    {{-- Boton para exportar en los distitos formatos --}}
                    <div class="dropdown custom-dropdown">
                        <button class="btn aquamarine-400 text-white dropdown-toggle" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Exportar
                        </button>
                        <ul class="dropdown-menu custom-dropdown-menu">
                            <li><a class="dropdown-item"
                                    href="{{ route('incidencias.exportar', ['tipo' => $incidencia->id, 'formato' => 'pdf']) }}">PDF</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('incidencias.exportar', ['tipo' => $incidencia->id, 'formato' => 'xlsx']) }}">EXCEL</a>
                            </li>
                            <li><a class="dropdown-item"
                                    href="{{ route('incidencias.exportar', ['tipo' => $incidencia->id, 'formato' => 'csv']) }}">CSV</a>
                            </li>
                        </ul>
                    </div>

                    @if (
                        (auth()->user()->hasrole('profesor') && $incidencia->estado != 'CERRADA') ||
                            auth()->user()->hasrole('administrador'))
                        {{-- Boton y desplegabale para los comentarios --}}
                        <div class="navbar bg-body-tertiary py-0" aria-label="Light offcanvas navbar">
                            <div>
                                <button class="btn aquamarine-400 text-white" type="button" data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasNavbarLight2" aria-controls="offcanvasNavbarLight2"
                                    aria-label="Toggle navigation">
                                    Comentarios
                                    <i class="bi bi-chat"></i>
                                </button>

                                {{-- Desplegable con comentarios --}}
                                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbarLight2"
                                    aria-labelledby="offcanvasNavbarLightLabel2">
                                    <div class="offcanvas-header mb-2">
                                        <h5 class="offcanvas-title" id="offcanvasNavbarLightLabel">Comentarios</h5>

                                        {{-- Boton para cerrar el desplegable --}}
                                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                            aria-label="Close"></button>
                                    </div>

                                    {{-- Contendor comentarios --}}
                                    <div class="offcanvas-body d-flex flex-column">
                                        @forelse ($comentarios as $comentario)
                                            <p>
                                                <span>{{ $comentario->user->nombre_completo }}:</span>
                                                {{ $comentario->texto }}
                                                {{-- Verificar si el usuario tiene el rol "admin" --}}
                                                @if ($comentario->user->hasRole('admin'))
                                                    <span>(Admin)</span>
                                                @endif

                                                {{-- O verificar si el usuario tiene alguno de los roles especificados --}}
                                                @if ($comentario->user->hasAnyRole(['admin', 'moderator']))
                                                    <span>(Admin o Moderador)</span>
                                                @endif

                                                {{-- Si el comentario tiene archivo adjunto, muestra el botón para descargar --}}
                                                @if ($comentario->adjunto_url != null)
                                                    {{-- Maquetar esto bien para que se vea un poco separado del texto o lo que sea --}}
                                                    <span>Archivo adjunto: <a
                                                            href="{{ route('descargar.comentario.archivo', ['id' => $comentario->id]) }}"
                                                            class="btn aquamarine-400 text-white">Descargar
                                                            Archivo</a></span>
                                                @endif
                                            </p>
                                        @empty
                                            <p>No hay comentarios</p>
                                        @endforelse

                                        {{-- Contenedor de envio de mensaje --}}
                                        <div class="offcanvas-body d-flex flex-column fixed-bottom">

                                        </div>
                                        <div class="offcanvas-footer mb-2 fixed-bottom position-relative">
                                            <form action="{{ route('comentarios.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                {{-- Campo escondido para mandar el id de la incidencia --}}
                                                <input type="hidden" name="incidencia_id" value="{{ $incidencia->id }}">
                                                {{-- Molaria un div como whatsapp en el que puedas meter mensaje y a la derecha un clip para elegir archivo --}}
                                                <div>
                                                    <input type="text" name="texto" placeholder="Mensaje">
                                                    <input type="file" id="fichero" name="fichero">
                                                </div>
                                                {{-- Botonn de enviar puede ser icono como whatsapp o alguna cosa así --}}
                                                <button type="submit" class="btn btn-danger text-white">Enviar</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Información de la incidencia --}}
        <div class="card mb-5 aquamarine-100">

            {{-- Encabezado del la tarjeta --}}
            <div class="card-header p-2">
                <h4 class="card-title">Detalles de la Incidencia</h4>
            </div>

            {{-- Cuerpo de la tarjeta --}}
            <div class="card-body">
                {{-- Fila id --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Id:</span> {{ $incidencia->id }}
                    </div>
                </div>

                {{-- Fila tipo, sub-tipo y sub-sub-tipo --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Tipo:</span> {{ $incidencia->tipo }}
                    </div>

                    <!-- Si no hay sub-tipos de incidencias no se muestra -->
                    @isset($incidencia->subtipo->subtipo_nombre)
                        <div class="col-lg-4">
                            <span class="fw-bolder">Subtipo:</span> {{ $incidencia->subtipo->subtipo_nombre }}
                        </div>
                    @endisset

                    <!-- Si no hay sub-sub-tipos de incidencias no se muestra -->
                    @isset($incidencia->subtipo->sub_subtipo)
                        <div class="col-lg-4">
                            <span class="fw-bolder">Subsubtipo:</span> {{ $incidencia->subtipo->sub_subtipo }}
                        </div>
                    @endisset
                </div>

                {{-- Fila creador, fecha creacion y fecha cierre --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Creador:</span>
                        {{ $incidencia->creador->nombre_completo }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Fecha de creación:</span> {{ $incidencia->fecha_creacion }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Fecha de cierre:</span> {{ $incidencia->fecha_cierre }}
                    </div>
                </div>

                {{-- Fila estado,  prioridad y duracion --}}
                <div class="row mb-4">
                    <div class="col-lg-4">
                        <span class="fw-bolder">Estado:</span> {{ $incidencia->estado }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Prioridad:</span> {{ $incidencia->prioridad }}
                    </div>
                    <div class="col-lg-4">
                        <span class="fw-bolder">Duración:</span> {{ $incidencia->duracion }}
                    </div>
                </div>

                {{-- Fila equipo --}}
                {{-- Si el tipo es equipos mostramos el equipo --}}
                @if ($incidencia->tipo == 'EQUIPOS')
                    <div class="row mb-4">
                        <!-- Si el equipo no es null mostramos sus datos, en caso contrario mostramos mensaje -->
                        <div class="col">
                        @empty($incidencia->equipo)
                            <span class="fw-bolder">Equipo:</span> No hay equipo asignado
                        @else
                            <span class="fw-bolder">Equipo:</span>
                            {{ $incidencia->equipo->aula->codigo . ' ' . $incidencia->equipo->etiqueta . ' ' . $incidencia->equipo->puesto }}
                        @endempty
                    </div>
            @endif

            <hr>

            {{-- Fila descripcion y actuaciones --}}
            <div class="row mb-4">
                <div class="col-lg-6">
                    <span class="fw-bolder">Descripción:</span>
                    <textarea class="form-control" rows="8" readonly>{{ $incidencia->descripcion }}</textarea>
                </div>
                <div class="col-lg-6">
                    <span class="fw-bolder">Actuaciones:</span>
                    <textarea class="form-control" rows="8" readonly>{{ $incidencia->actuaciones }}</textarea>
                </div>
            </div>

            {{-- Fila archivo y responsable --}}
            <div class="row mb-4">
                <div class="col-lg-6">
                    @if ($incidencia->adjunto_url != null)
                        <a href="{{ route('descargar.archivo', ['id' => $incidencia->id]) }}"
                            class="btn aquamarine-400 text-white">Descargar Archivo</a>
                    @else
                        <span class="fw-bolder">No hay archivo adjunto</span>
                    @endif
                </div>

                <div class="col-lg-6">
                    <span class="fw-bolder">Responsable:</span>
                    <!-- Si responsables esta vacio ponemos que aún no hay, en caso contrario los mostramos -->
                    @if ($incidencia->responsable == null)
                        Aún no hay responsables
                    @else
                        <span>{{ $incidencia->responsable->nombre_completo }} </span>
                    @endif
                </div>
            </div>

            {{-- Botones actilizar y borrar incidencia --}}
            <div class="row mt-5">
                <div class="d-flex gap-2">
                    <a href="{{ route('incidencias.edit', $incidencia) }}" type="button"
                        class="btn aquamarine-400 text-white">Editar</a>
                    <form action="{{ route('incidencias.destroy', $incidencia) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-danger text-white"data-bs-toggle="modal"
                            data-bs-target="#staticBackdrop">Borrar</button>
                    </form>
                </div>
            </div>
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
