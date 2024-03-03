addEventListener("load",inicio,false);

//vaiable para poder obtener el host
import {hostServer} from "./variableHost.js";
let host=hostServer;

//Funcion que se ejecuta cuando carga el html
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

//funcion para poder obtener los equipos de la aula seleccionada
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

//metodo para poder generar los subtipos en funcion del tipo
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

//funcion para poder generar los subsubtipos en funcion de los subtipos
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
