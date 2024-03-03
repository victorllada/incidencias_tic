addEventListener("load",inicio,false);

import {hostServer} from "./variableHost.js";
let host=hostServer;

function inicio()
{
    obtenerIncidencias().then(data => {
        console.log(data);

        //cargarEtiquetas(data);

        if(divEquipo.value=="EQUIPOS")
        {
            divEquipo.removeAttribute('hidden');
        }
    });
}

async function obtenerIncidencias()
{
    try
    {
        let ruta=host+'/obtener-etiquetas/'+aula.value;
        //llamada a la ruta de laravel para obtener los datos
        let response = await fetch(ruta);
        //console.log(response);
        // Comprueba si la respuesta es exitosa
        if(!response.ok)
        {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        //obtener un array de la respuesta del json
        let data = await response.json();

        //devolver el array final
        return data;
    }
    catch (error)
    {
        console.error('Ha ocurrido un error:', error);
    }
}

function cargarEtiquetas(datos)
{
    //num_etiqueta
    num_etiqueta.innerHTML = ""; // Limpiar opciones existentes
    let defaultOption = document.createElement('option'); //Creamos la opcion
    defaultOption.value = null; //Valor nulo
    defaultOption.text = "No hay equipos en este aula"; //Texto de muestra
    num_etiqueta.appendChild(defaultOption); //Añadimos la opcion

    //Si hay datos mostramos las etiquetas
    if (datos && datos.length>0)
    {
        datos.forEach(item => {
            num_etiqueta.removeChild(defaultOption); //Borramos la opcion default
            let option = document.createElement('option'); //Creamos una opcion
            option.value = item.etiqueta; //Valor de la opcion es la etiqueta
            option.text = item.etiqueta; //texto de la opcion es la etiqueta
            num_etiqueta.appendChild(option);
        });
    }
}


/*
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

    addEventListener('load', () => {
        //Guardamos en una variable el selec de tipo
        var tipo = document.getElementById("tipo");

        //Guardamos en una variable el selec de subtipos
        var subtipo = document.getElementById("sub-tipo");

        //Guardamos en una variable el selec de estado
        var estado = document.getElementById("estado");

        //Comprueba la primera vez que se carga la pagina si el tipo es EQUIPOS, y si es asi muestra el div-equipo
        comprobarTipo();

        //Genera los sub-tipos cuando se elije una opcion de tipos
        tipo.addEventListener('change', generarSubtipos);

        //Comprueba si se elije el tipo Equipos y hace que aparezcan los campos num_etiqueta, aula y puesto
        tipo.addEventListener('change', EquiposSelected);

        //Comprueba si se selecciona la opcion "yedra" en sub-tipos, e informa con un alert
        subtipo.addEventListener('change', comprobarYedra);

        //Genera los sub-sub-tipos cuando se elije una opcion de tipos
        subtipo.addEventListener('change', generarSubSubTipos);
    });


    function comprobarTipo() {

        var tipo = document.getElementById("tipo");
        var divEquipo = document.getElementById("div-equipo");

        if (tipo.value == "EQUIPOS") {
            divEquipo.hidden = false;
        }
    }


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


    function borrarSubOpciones() {
        var subtipo = document.getElementById("sub-tipo");

        while (subtipo.firstChild) {
            subtipo.removeChild(subtipo.firstChild);
        }
    }


    function comprobarYedra() {
        var subtipo = document.getElementById("sub-tipo");

        if (subtipo.value == "YEDRA") {
            alert("Esta gestión la realiza Jefatura de estudios");
        }
    }


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


    function borrarSubSubOpciones() {
        var subsubtipo = document.getElementById("sub-sub-tipo");

        while (subsubtipo.firstChild) {
            subsubtipo.removeChild(subsubtipo.firstChild);
        }
    }

    function EquiposSelected() {

        var selec = document.getElementById("tipo");

        if (selec.value === "EQUIPOS") {
            document.getElementById("div-equipo").hidden = false;
        } else {
            document.getElementById("div-equipo").hidden = true;
        }
    }*/
