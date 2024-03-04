/**
 * Registra un evento para el manejo del evento 'load', ejecutando la función 'inicio' cuando la página se carga completamente.
 * @param {string} type - El tipo de evento ('load' en este caso).
 * @param {function} listener - La función que se llamará cuando ocurra el evento.
 * @param {boolean} useCapture - Especifica si se debe usar la fase de captura (false en este caso).
 * @returns {void}
 */
addEventListener("load",inicio,false);

/**
 * Importa la constante 'hostServer' desde el módulo "./variableHost.js" y la asigna a la variable 'host'.
 * @type {string} - El valor de 'hostServer' importado.
 */
import {hostServer} from "./variableHost.js";
let host=hostServer;

/**
 * Función que realiza acciones al cargar la página.
 * - Muestra los valores de la clase y el número de etiqueta si el tipo es "EQUIPOS".
 * - Genera los subtipos.
 * - Registra eventos para cambios en los elementos tipo, sub-tipo y aula, ejecutando funciones específicas.
 * @returns {void}
 */
function inicio()
{
    //para que muestre los valores de la clase y el numero de etiqueta
    if(tipo.value=="EQUIPOS")
    {
        divEquipo.removeAttribute('hidden');
    }
    generarSubtipos();

    tipo.addEventListener("change",generarSubtipos,false);
    subTipo.addEventListener("change",generarSubSubTipos,false);
    aula.addEventListener("change",obtenerEquiposAula,false);
}

/**
 * Realiza una llamada asíncrona a la ruta de Laravel para obtener etiquetas según el aula seleccionada.
 * Actualiza el select de equipos con los datos obtenidos.
 * @throws {Error} - Lanza un error si la respuesta HTTP no es exitosa.
 * @returns {Promise<void>} - Una promesa que se resuelve después de actualizar el select de equipos.
 */
async function obtenerEquiposAula()
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

        //metodo para poder reyenar el select de los equipos
        cargarEtiquetas(data)
        //return data;
    }
    catch (error)
    {
        console.error('Ha ocurrido un error:', error);
    }
}

/**
 * Rellena el select de números de etiqueta con los datos de los equipos proporcionados.
 * @param {Array} equipos - Un array de objetos representando los equipos con sus números de etiqueta.
 * @returns {void}
 */
function cargarEtiquetas(equipos)
{
    //console.log(equipos);

    //comprovacion por si el aula no tiene equipos
    if(equipos.length>0)
    {
        num_etiqueta.innerHTML="";

        equipos.forEach(equipo=> {
            //console.log(equipo);

            let opt=document.createElement("option");
            opt.value=equipo.etiqueta;
            opt.innerHTML=equipo.etiqueta;

            num_etiqueta.appendChild(opt);
        });
    }
    else
    {
        num_etiqueta.innerHTML="";

        let opt=document.createElement("option");
        opt.value=null;
        opt.innerHTML="no hay equipos registrados en esta aula";

        num_etiqueta.appendChild(opt);
    }
}

/**
 * Genera y actualiza las opciones del select de subtipos según el tipo seleccionado.
 * Además, controla la visibilidad de los elementos divEquipo, div-sub-sub-tipo y div-sub-tipo en función del tipo seleccionado.
 * @returns {void}
 */
function generarSubtipos()
{
    subTipo.innerHTML="<option selected value='-1'>Seleccione el sub-tipo</option>";
    let subtipos=[];

    switch (tipo.value)
    {
        case "CUENTAS":
            subtipos = ["EDUCANTABRIA","GOOGLE CLASSROOM","DOMINIO","YEDRA"];
            break;
        case "EQUIPOS":
            subtipos=["ALTAVOCES","PC","MONITOR","PROYECTOR","PANALLA INTERACTIVA","PORTATIL","IMPRESORA"];
            break;
        case "WIFI":
            subtipos=["IESMIGUELHERRERO","WIECAN"];
            break;
        case "INTERNET":
            subtipos=[];
            break;
        case "SOFTWARE":
            subtipos=["INSTALACION","ACTUALIZACION"];
            break;
    }

    for (let i = 0; i < subtipos.length; i++)
    {
        let opt=document.createElement("option");
        opt.innerHTML=subtipos[i];
        opt.value=subtipos[i];

        subTipo.appendChild(opt);
    }

    //if para enseñar el select de aula y de numero de etiqueta
    if(tipo.value!="EQUIPOS")
    {
        document.querySelector("#divEquipo").hidden=true;
        document.querySelector("#div-sub-sub-tipo").hidden=true;
    }
    else
    {
        document.querySelector("#divEquipo").hidden=false;
        document.querySelector("#div-sub-sub-tipo").hidden=false;
    }

    //if para poder saber si el tipo es interne, por que no tiene subtipos
    if (tipo.value=="INTERNET")
    {
        document.querySelector("#div-sub-tipo").hidden=true;
        document.querySelector("#div-sub-sub-tipo").hidden=true;
    }
    else
    {
        document.querySelector("#div-sub-tipo").hidden=false;
    }
}

/**
 * Genera y actualiza las opciones del select de sub-subtipos según el sub-tipo seleccionado.
 * Controla la visibilidad del elemento div-sub-sub-tipo en función del sub-tipo seleccionado.
 * @returns {void}
 */
function generarSubSubTipos()
{
    subSubTipo.innerHTML="<option selected value='-1'>Selecciona el sub-subtipo</option>";
    let subsubtipos=[];

    switch (subTipo.value) {
        case "PC":
            subsubtipos = ["RATON", "ORDENADOR", "TECLADO"];
            break;
        case "PORTATIL":
            subsubtipos = ["PORTATIL PROPORCIONADO POR CONSERJERIA", "DE AULA", "DE PUESTO"];
            break;
        default:
            document.querySelector("#div-sub-sub-tipo").hidden=true;
            break;
    }

    if (subsubtipos.length>0)
    {
        for (let i=0;i<subsubtipos.length;i++)
        {
            var opt=document.createElement("option");
            opt.textContent=subsubtipos[i];
            opt.setAttribute("value",subsubtipos[i]);

            subSubTipo.appendChild(opt);
        }

        document.querySelector("#div-sub-sub-tipo").hidden=false;
    }
}
