@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Crear')
@section('contenido')

    <style>
        form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>

    <div class="container">

        {{-- Migas de pan --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('incidencias.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Crear incidencia</li>
            </ol>
        </nav>

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
        <form action="{{ route('incidencias.store') }}" method="post" enctype="multipart/form-data">
            @csrf
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
                                    <option selected disabled value="-1">Selecciona el tipo</option>
                                    <option value="CUENTAS">Cuentas</option>
                                    <option value="EQUIPOS">Equipos</option>
                                    <option value="WIFI">Wifi</option>
                                    <option value="INTERNET">Internet</option>
                                    <option value="SOFTWARE">Software</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" hidden>
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="sub-tipo">Sub-tipo</label>
                                <select class="form-select" name="sub-tipo" id="sub-tipo" required>
                                    <option selected disabled value="-1">Selecciona el subtipo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" hidden>
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder"
                                    for="sub-sub-tipo">Sub-sub-tipo</label>
                                <select class="form-select" name="sub-sub-tipo" id="sub-sub-tipo" required>
                                    <option selected disabled value="-1">Selecciona el sub-subtipo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Fila 2 prioridad --}}
                    <div class="row mb-4">
                        <div class="col-4">
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

                    {{-- Fila 3  en caso de que el tipo sea equipos --}}
                    {{-- Hay que hacer el hidden en el div de la fila  asi hacer invisible y cuando el tipo sea equipos sea visible --}}
                    <div class="row mb-4" hidden>
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
                                <input type="text" class="form-control" name="aula" id="aula"
                                    placeholder="IF-04">
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

                    {{-- Fila 4 descripción y archivo --}}
                    <div class="row mb-4">
                        <div class="col-lg-6">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder"
                                    for="descripcion">Descripción</label>
                                <textarea class="form-control" placeholder="Deja aqui tus comentarios" id="floatingTextarea" rows="8"
                                    maxlength="256"></textarea>
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

                    {{-- Aqui se generara un checklist con todos los profesores del centro --}}
                    <div class="row mb-4">
                        <div class="col input-group">
                            <label class="input-group-text aquamarine-200 fw-bolder" for="asignado">Asignado</label>
                            <div class="d-flex flex-wrap gap-4 form-control ">
                                <div>
                                    <input class="form-check-input" type="checkbox" id="checkbox1" name="checkboxGroup">
                                    <label class="form-check-label" for="checkbox1">Opción 1</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Boton para crear incidencia --}}
                    <div class="row">
                        <div class="col">
                            <input type="submit" class="btn aquamarine-400 text-white" value="Crear incidencia">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection


<!--Hay que pasar el script a un fichero y ademas añadir validaciones antes de enviar form-->
<script>
    addEventListener('load', () => {
        //Guardamos en una variable el selec de tipo
        var tipo = document.getElementById("tipo");

        //Guardamos en una variable el selec de subtipos
        var subtipo = document.getElementById("subtipo");

        //Genera los sub-tipos la primera vez, cuando se carga la página
        generarSubtipos();

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
        var subtipo = document.getElementById("subtipo");

        var subsubtipo = document.getElementById("subsubtipo");
        var lbl_subsubtipo = document.getElementById("lbl_subsubtipo");

        borrarSubOpciones();
        borrarSubSubOpciones();

        switch (selec.value) {
            case "cuentas":
                var array = ["Educantabria", "Google Classroom", "Dominio", "Yedra"];
                break;
            case "equipos":
                var array = ["Altavoces", "PC", "Monitor", "Proyector", "Pantalla interactiva", "Portátil",
                    "Impresoras"
                ];
                break;
            case "wifi":
                var array = ["Iesmiguelherrero", "WIECAN"];
                break;
            case "internet":
                var array = ["Instalación", "Actualización"];
                break;
            case "software":
                var array = ["Instalación", "Actualización"];
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

        subsubtipo.hidden = true;
        lbl_subsubtipo.hidden = true;
    }

    /**
     *Borra todas las opciones del selec de sub-tipos
     */
    function borrarSubOpciones() {
        var subtipo = document.getElementById("subtipo");

        while (subtipo.firstChild) {
            subtipo.removeChild(subtipo.firstChild);
        }
    }

    /**
     * Comprueba si se selecciona el sub-tipo "yedra", y si es así saca alert con información
     */
    function comprobarYedra() {
        var subtipo = document.getElementById("subtipo");

        if (subtipo.value == "Yedra") {
            alert("Esta gestión la realiza Jefatura de estudios");
        }
    }

    /**
     * Genera los sub-sub-tipo dependiendo del sub-tipo seleccionado
     */
    function generarSubSubTipos() {

        var subtipo = document.getElementById("subtipo");
        var subsubtipo = document.getElementById("subsubtipo");
        var lbl_subsubtipo = document.getElementById("lbl_subsubtipo");

        borrarSubSubOpciones();

        switch (subtipo.value) {
            case "PC":
                var array = ["Ratón", "Ordenador", "Teclado"];
                break;
            case "Portátil":
                var array = ["Portátil proporcionado por Consejería", "Portátil de aula", "Portátil de puesto"];
                break;
            default:
                borrarSubSubOpciones();
                subsubtipo.hidden = true;
                lbl_subsubtipo.hidden = true;
                break;
        }

        if (array) {
            for (let i = 0; i < array.length; i++) {
                var opt = document.createElement("option");
                opt.textContent = array[i];
                opt.setAttribute("value", array[i]);
                subsubtipo.appendChild(opt);
            }

            subsubtipo.hidden = false;
            lbl_subsubtipo.hidden = false;
        }

    }

    /**
     *Borra todas las sub-sub-opciones del selec de sub-sub-tipos
     */
    function borrarSubSubOpciones() {
        var subsubtipo = document.getElementById("subsubtipo");

        while (subsubtipo.firstChild) {
            subsubtipo.removeChild(subsubtipo.firstChild);
        }
    }

    /**
     * Cambia si los campos num_etiqueta, aula y puesto se muestran o no, en funcion a si se selecciona el tipo equipos, o no
     */
    function EquiposSelected() {

        var selec = document.getElementById("tipo");

        if (selec.value === "equipos") {
            document.getElementById("num_etiqueta").hidden = false;
            document.getElementById("aula").hidden = false;
            document.getElementById("puesto").hidden = false;
            document.getElementById("lbl_num_etiqueta").hidden = false;
            document.getElementById("lbl_aula").hidden = false;
            document.getElementById("lbl_puesto").hidden = false;
        } else {
            document.getElementById("num_etiqueta").hidden = true;
            document.getElementById("aula").hidden = true;
            document.getElementById("puesto").hidden = true;
            document.getElementById("lbl_num_etiqueta").hidden = true;
            document.getElementById("lbl_aula").hidden = true;
            document.getElementById("lbl_puesto").hidden = true;
        }
    }
</script>
