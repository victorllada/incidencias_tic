@extends('layouts.plantilla')
@section('titulo', 'Incidencias - show')
@section('archivosJS')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
@endsection
@section('contenido')

    <div class="container">

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
                    <button class="btn aquamarine-400 text-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
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

                {{-- Boton y desplegabale para los comentarios --}}
                <div class="navbar bg-body-tertiary py-0" aria-label="Light offcanvas navbar">
                    <div>
                        <button class="btn aquamarine-400 text-white" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasNavbarLight2" aria-controls="offcanvasNavbarLight2"
                            aria-label="Toggle navigation">
                            Comentarios
                        </button>

                        {{-- Desplegable con informes --}}
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbarLight2"
                            aria-labelledby="offcanvasNavbarLightLabel2">
                            <div class="offcanvas-header mb-2">
                                <h5 class="offcanvas-title" id="offcanvasNavbarLightLabel">Comentarios</h5>

                                {{-- Boton para cerrar el desplegable --}}
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close"></button>
                            </div>

                            {{-- Contendor comentarios --}}
                            <div class="offcanvas-body d-flex flex-column gap-5 pt-5">


                            </div>
                        </div>
                    </div>
                </div>
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
                @if ($responsables->isEmpty())
                    Aún no hay responsables
                @else
                    @foreach ($responsables as $responsable)
                        <span>{{ $responsable->nombre_completo }} </span>
                    @endforeach
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
                    <button type="submit" class="btn aquamarine-400 text-white">Borrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
