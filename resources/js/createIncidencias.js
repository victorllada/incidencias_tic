/**
 * Registra un evento para el manejo del evento 'load'.
 * @param {string} type - El tipo de evento ('load' en este caso).
 * @param {function} listener - La función que se llamará cuando ocurra el evento.
 * @param {boolean} useCapture - Especifica si se debe usar la fase de captura (false en este caso).
 * @returns {void}
 */
addEventListener("load", inicio, false);

/**
 * Función de inicio que realiza diversas acciones al cargar la página.
 * - Registra eventos para cambios en los elementos tipo, sub-tipo, aula y sub-sub-tipo.
 * - Ejecuta funciones específicas en respuesta a ciertos eventos.
 * @returns {void}
 */
function inicio() {
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

    //Genera las etiquetas
    aula.addEventListener("change", cargarEtiquetas, false);
}

/**
 * Realiza una petición AJAX para obtener las etiquetas según el aula seleccionada y actualiza el select de etiquetas.
 * @returns {void}
 */
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
            var array = ["ALTAVOCES", "PC", "MONITOR", "PROYECTOR", "PANTALLA", "PANTALLA INTERACTIVA", "PORTATIL",
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

    document.getElementById("div-sub-sub-tipo").hidden = true;


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
        case "PORTATIL":
            var array = ["PROPORCIONADO POR CONSEJERIA", "DE AULA", "DE PUESTO"];
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
