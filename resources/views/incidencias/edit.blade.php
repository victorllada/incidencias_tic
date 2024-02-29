@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Editar')
@section('archivosJS')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
@endsection
@section('contenido')

    <div class="container">
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

        <!--Falta añadir la ruta del store en el atributo action del form-->
        <form action="{{ route('incidencias.update', $incidencia) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="card mb-5 aquamarine-100">
                <div class="card-header p-2">
                    <h4 class="card-title">Datos de la Incidencia</h4>
                </div>

                <div class="card-body">

                    {{-- Fila 1 tipo sub-tipo y sub-sub-tipo --}}
                    {{-- Hay que hacer el hidden en los div de cada columna para asi hacer invisible sub-tipo y sub-sub-tipo --}}
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
                                <label class="input-group-text aquamarine-200 fw-bolder" for="sub-tipo">Sub-tipo</label>
                                <select class="form-select" name="sub-tipo" id="sub-tipo">
                                    <option selected disabled value="-1">Selecciona el subtipo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" id="div-sub-sub-tipo">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder"
                                    for="sub-sub-tipo">Sub-sub-tipo</label>
                                <select class="form-select" name="sub-sub-tipo" id="sub-sub-tipo">
                                    <option selected disabled value="-1">Selecciona el sub-subtipo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Fila 2  en caso de que el tipo sea equipos --}}
                    {{-- Hay que hacer el hidden en el div de la fila  asi hacer invisible y cuando el tipo sea equipos sea visible --}}
                    <div class="row mb-4" id="div-equipo">
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="num_etiqueta">Numero de
                                    etiqueta</label>
                                <input type="number" class="form-control" name="num_etiqueta" id="num_etiqueta"
                                    placeholder="123456" pattern="[0-9]*">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="aula">
                                    Aula</label>
                                <select class="form-select" name="aula" id="aula" required>
                                    <option selected disabled value="-1">Selecciona el aula</option>
                                    @foreach ($aulas as $aula)
                                        <option value={{ $aula->id }}>{{ $aula->codigo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="puesto">Puesto de
                                    Aula</label>
                                <input type="number" class="form-control" name="puesto" id="puesto" placeholder="1"
                                    pattern="[0-9]*">
                            </div>
                        </div>
                    </div>

                    {{-- Fila 3 prioridad, estado y duracion --}}
                    <div class="row mb-4">
                        <div class="col-4">
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

                        <div class="col-4">
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
                                    <option value="EN PROCESO"
                                        {{ $incidencia->estado == 'EN PROCESO' ? 'selected' : '' }}>
                                        En proceso
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="duracion">
                                    Duración
                                </label>
                                <input type="number" class="form-control" name="duracion" id="duracion"
                                    placeholder="60" pattern="[0-9]*" value="{{ $incidencia->duracion }}">
                            </div>
                        </div>
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
                                    rows="8" maxlength="256">{{ $incidencia->actuaciones }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Archivo adjunto --}}
                    <div class="row mb-4">
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

                    {{-- Aqui se generara un checklist con todos los profesores del centro --}}
                    <div class="row mb-4">
                        <div class="col input-group">
                            <label class="input-group-text aquamarine-200 fw-bolder" for="asignado">Asignado</label>
                            <div class="d-flex flex-wrap gap-4 form-control ">
                                @forelse ($usuarios as $usuario)
                                    <div>
                                        <input class="form-check-input" type="checkbox" id="asignado[]"
                                            name="asignado[]" value={{ $usuario->id }}>
                                        <label class="form-check-label"
                                            for="asignado[]">{{ $usuario->nombre_completo }}</label>
                                    </div>
                                @empty
                                    <div>No hay usuarios</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Boton para editar incidencia --}}
                    <div class="row">
                        <div class="col">
                            <input type="submit" class="btn aquamarine-400 text-white" value="Actualizar">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

<!--Hay que pasar el script a un fichero y ademas añadir validaciones antes de enviar form-->
<!--Hay que pasar el script a un fichero y ademas añadir validaciones antes de enviar form-->
<script>
    addEventListener('load', () => {
        //Guardamos en una variable el selec de tipo
        var tipo = document.getElementById("tipo");

        //Guardamos en una variable el selec de subtipos
        var subtipo = document.getElementById("sub-tipo");

        //Genera los sub-tipos cuando se elije una opcion de tipos
        tipo.addEventListener('change', generarSubtipos);

        //Comprueba si se elije el tipo Equipos y hace que aparezcan los campos num_etiqueta, aula y puesto
        tipo.addEventListener('change', EquiposSelected);

        //Comprueba si se selecciona la opcion "yedra" en sub-tipos, e informa con un alert
        subtipo.addEventListener('change', comprobarYedra);

        //Genera los sub-sub-tipos cuando se elije una opcion de tipos
        subtipo.addEventListener('change', generarSubSubTipos);

    });

    /**
     * Genera los sub-tipos dependiendo de lo seleccionado en tipos
     */
    function generarSubtipos() {
        var selec = document.getElementById("tipo");
        var subtipo = document.getElementById("sub-tipo");

        var subsubtipo = document.getElementById("sub-sub-tipo");

        borrarSubOpciones();
        borrarSubSubOpciones();

        switch (selec.value) {
            case "CUENTAS":
                var array = ["EDUCANTABRIA", "GOOGLE CLASSROOM", "DOMINIO", "YEDRA"];
                break;
            case "EQUIPOS":
                var array = ["ALTAVOCES", "PC", "MONITOR", "PROYECTOR", "PANALLA INTERACTIVA", "PORTATIL",
                    "IMPRESORA"
                ];
                break;
            case "WIFI":
                var array = ["IESMIGUELHERRERO", "WIECAN"];
                break;
            case "INTERNET":
                var array = [];
                break;
            case "SOFTWARE":
                var array = ["INSTALACION", "ACTUALIZACION"];
                break;
            default:
                break;
        }

        for (let i = 0; i < array.length; i++) {
            var opt = document.createElement("option");
            opt.textContent = array[i];
            opt.setAttribute("value", array[i]);
            subtipo.appendChild(opt);
        }

        if (selec.value == "INTERNET") {
            document.getElementById("div-sub-tipo").hidden = true;
        } else {
            document.getElementById("div-sub-tipo").hidden = false;
        }

    }


    /**
     *Borra todas las opciones del selec de sub-tipos
     */
    function borrarSubOpciones() {
        var subtipo = document.getElementById("sub-tipo");

        while (subtipo.firstChild) {
            subtipo.removeChild(subtipo.firstChild);
        }
    }

    /**
     * Comprueba si se selecciona el sub-tipo "yedra", y si es así saca alert con información
     */
    function comprobarYedra() {
        var subtipo = document.getElementById("sub-tipo");

        if (subtipo.value == "YEDRA") {
            alert("Esta gestión la realiza Jefatura de estudios");
        }
    }

    /**
     * Genera los sub-sub-tipo dependiendo del sub-tipo seleccionado
     */
    function generarSubSubTipos() {

        var subtipo = document.getElementById("sub-tipo");
        var subsubtipo = document.getElementById("sub-sub-tipo");

        borrarSubSubOpciones();

        switch (subtipo.value) {
            case "PC":
                var array = ["RATON", "ORDENADOR", "TECLADO"];
                break;
            case "Portátil":
                var array = ["PORTATIL PROPORCIONADO POR CONSERJERIA", "DE AULA", "DE PUESTO"];
                break;
            default:
                borrarSubSubOpciones();
                document.getElementById("div-sub-sub-tipo").hidden = true;
                break;
        }

        if (array) {
            for (let i = 0; i < array.length; i++) {
                var opt = document.createElement("option");
                opt.textContent = array[i];
                opt.setAttribute("value", array[i]);
                subsubtipo.appendChild(opt);
            }

            document.getElementById("div-sub-sub-tipo").hidden = false;
        }

    }

    /**
     *Borra todas las sub-sub-opciones del selec de sub-sub-tipos
     */
    function borrarSubSubOpciones() {
        var subsubtipo = document.getElementById("sub-sub-tipo");

        while (subsubtipo.firstChild) {
            subsubtipo.removeChild(subsubtipo.firstChild);
        }
    }

    /**
     * Cambia si los campos num_etiqueta, aula y puesto se muestran o no, en funcion a si se selecciona el tipo equipos, o no
     */
    function EquiposSelected() {

        var selec = document.getElementById("tipo");

        if (selec.value === "EQUIPOS") {
            document.getElementById("div-equipo").hidden = false;
        } else {
            document.getElementById("div-equipo").hidden = true;
        }
    }
</script>
