@extends('layouts.plantilla')
@section('titulo', 'Incidencias - Crear')
@section('contenido')

    <h1>Crear incidencia</h1>

    <form action="" method="post" enctype="multipart/form-data">
        @csrf

        <!--El id se genera/recoge con el ultimo de la BD +1-->
        <label for="id">Id:</label>
        <input type="text" name="id" id="id" readonly>

        <label for="fecha_hora">Fecha y hora:</label>
        <input type="text" name="fecha_hora" id="fecha_hora" value="{{ now() }}" readonly>

        <!--Los campos nombre completo se rellenara automaticamente con los datos del usuario-->
        <label for="nombre">Nombre completo:</label>
        <input type="text" name="nombre" id="nombre">

        <label for="departamento">Departamento:</label>
        <select name="departamento" id="departamento">
            <!--Rellenar con BD-->
        </select>

        <label for="asignado">Asigandao a:</label>
        <div id="asignado">
            <!--Aqui se generara un checklist con todos los profesores del centro-->
        </div>

        <label for="tipo">Tipo:</label>
        <select name="tipo" id="tipo">
            <option value="cuentas">Cuentas</option>
            <option value="equipos">Equipos</option>
            <option value="wifi">Wifi</option>
            <option value="internet">Internet</option>
            <option value="software">Software</option>
        </select>

        <label for="subtipo">Sub-tipo:</label>
        <select name="subtipo" id="subtipo">
        </select>

        <label for="subsubtipo" id="lbl_subsubtipo" hidden>Sub-sub-tipo:</label>
        <select name="subsubtipo" id="subsubtipo" hidden>
        </select>

        <label for="num_etiqueta" id="lbl_num_etiqueta" hidden>Número etiqueta:</label>
        <input type="text" name="num_etiqueta" id="num_etiqueta" hidden>

        <label for="aula" id="lbl_aula" hidden>Aula:</label>
        <input type="text" name="aula" id="aula" hidden>

        <label for="puesto" id="lbl_puesto" hidden>Puesto:</label>
        <input type="text" name="puesto" id="puesto" hidden>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion" id="descripcion"></textarea>

        <label for="fichero">Fichero:</label>
        <input type="file" name="fichero" id="fichero">

        <label for="estado">Estado:</label>
        <select name="estado" id="estado">
            <option value="abierto">Abierto</option>
            <option value="asignado">Asignado</option>
            <option value="en_proceso">En Proceso</option>
            <option value="enviado_a_infortec">Enviado a Infortec</option>
            <option value="resuelto">Resuelto</option>
            <option value="cerrado">Cerrado</option>
        </select>

        <label for="actuaciones">Actuaciónes:</label>
        <textarea name="actuaciones" id="actuaciones"></textarea>

        <label for="prioridad">Prioridad:</label>
        <select name="prioridad" id="prioridad">
            <option value="baja">Baja</option>
            <option value="media">Media</option>
            <option value="alta">Alta</option>
            <option value="urgente">Urgente</option>
        </select>

    </form>

@endsection

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
