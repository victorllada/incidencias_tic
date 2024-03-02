@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Crear')
@section('archivosJS')
    @vite(['resources/js/app.js'])
@endsection
@section('contenido')

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
                        <div class="col-lg-4" id="div-sub-tipo" hidden>
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="sub-tipo">Sub-tipo</label>
                                <select class="form-select" name="sub-tipo" id="sub-tipo">
                                    <option selected disabled value="-1">Selecciona el subtipo</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4" id="div-sub-sub-tipo" hidden>
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder"
                                    for="sub-sub-tipo">Sub-sub-tipo</label>
                                <select class="form-select" name="sub-sub-tipo" id="sub-sub-tipo">
                                    <option selected disabled value="-1">Selecciona el sub-subtipo</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Fila 3  en caso de que el tipo sea equipos --}}
                    {{-- Hay que hacer el hidden en el div de la fila  asi hacer invisible y cuando el tipo sea equipos sea visible --}}
                    <div class="row mb-4" id="div-equipo" hidden>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="aula">
                                    Aula</label>
                                <select class="form-select" name="aula" id="aula" required
                                    onchange="cargarEtiquetas()">
                                    <option selected disabled value="-1">Selecciona el aula</option>
                                    @foreach ($aulas as $aula)
                                        <option value={{ $aula->id }}>{{ $aula->codigo }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="num_etiqueta">Numero de
                                    etiqueta</label>
                                <select class="form-select" name="num_etiqueta" id="num_etiqueta" required>
                                    <option selected disabled value="-1">Selecciona la etiqueta</option>
                                </select>
                            </div>
                        </div>

                        {{-- Igual lo quitamos porque no es necesario realmente, creo
                        <div class="col-lg-4">
                            <div class="input-group">
                                <label class="input-group-text aquamarine-200 fw-bolder" for="puesto">Puesto de
                                    Aula</label>
                                <select class="form-select" name="puesto" id="puesto" required>
                                    <option selected disabled value="-1">Selecciona ell puesto</option>
                                </select>
                            </div>
                        </div>
                        --}}

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
                                    rows="8" maxlength="256"></textarea>
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

<script>
    function cargarEtiquetas() {
        var aulaId = document.getElementById('aula').value; //Obtener el id del aula actual

        // Realizar una petición AJAX para obtener las etiquetas según el aula seleccionada
        fetch('/obtener-etiquetas/' + aulaId)
            .then(response => response.json())
            .then(data => {
                var selectEtiqueta = document.getElementById('num_etiqueta'); //obtenemos el select de etiquetas
                selectEtiqueta.innerHTML = ""; // Limpiar opciones existentes

                var defaultOption = document.createElement('option'); //Creamos la opcion
                defaultOption.value = null; //Valor nulo
                defaultOption.text = "No hay equipos en este aula"; //Texto de muestra
                selectEtiqueta.add(defaultOption); //Añadimos la opcion

                if (data && data.length > 0) { //Si hay datos mostramos las etiquetas

                    selectEtiqueta.removeChild(defaultOption); //Borramos la opcion default

                    data.forEach(etiqueta => { //Por cada etiqueta
                        var option = document.createElement('option'); //Creamos una opcion
                        option.value = etiqueta.etiqueta; //Valor de la opcion es la etiqueta
                        option.text = etiqueta.etiqueta; //texto de la opcion es la etiqueta
                        selectEtiqueta.add(option); //Añadimos la opcion
                    });
                }

            })
            .catch(error => console.error('Error:', error)); //Obtenemos el error
    }
</script>

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
            case "SOFTWARE":
                var array = ["INSTALACION", "ACTUALIZACION"];
                break;
            case "INTERNET":
                var array = [];
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
