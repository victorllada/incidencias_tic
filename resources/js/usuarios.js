addEventListener("load",inicio,false);

let datosUsuarios;
let datosFinales=[];
let datosPaginacion=[];
let pagina=0;
//varialbe de host del servidor para poder conectarme al mismo
import {hostServer} from "./variableHost.js";
//variable para poder usar en todo donde haga falta llamar al servidor
let host=hostServer;

function inicio()
{
    //llamada de ajax y creacion de las incidencias en el html
    obtenerIncidencias().then(data => {
        datosUsuarios = data; // Guardamos los datos en la variable
        console.log(datosUsuarios); // Ahora deberías poder ver los datos

        crearArrayPaginacion(datosUsuarios);

        //console.log(datosPaginacion);

        generarUsuarios(datosPaginacion);


    });
    //llamadas a los metodos para los filtros
    filtrar.addEventListener("click",aplicacionFiltros,false);
    borrar.addEventListener("click",borrarFiltros,false);

    //llamadas a los metodos para la paginacion
    inicioPaginacion.addEventListener("click",paginacionInicio,false);
    anterior.addEventListener("click",paginaAnterior,false);
    paginaActual.addEventListener("keyup",paginaEscrita,false);
    siguiente.addEventListener("click",paginaSiguiente,false);
    finalPaginacion.addEventListener("click",paginacionFin,false);
}

//Funcion para obtener todas las incidencias a traves de ajax
async function obtenerIncidencias()
{
    try
    {
        let ruta=host+"/datosUsuarios";
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

//metodo para crear el array para usarlo en la paginacion
function crearArrayPaginacion(array)
{
    //vacio el array
    datosPaginacion=[];

    //dividir el array de entrada en arrays de tamaño 10
    for (let i=0;i<array.length; i+=10)
    {
        datosPaginacion.push(array.slice(i, i+10));
    }
}

//funcion para mostrar la primera pagina
function paginacionInicio()
{
    //colocar la variable pagina a 0 para que sea la primea pagina en mostrarse
    pagina=0;

    //mostrar en el input la pagina actual
    paginaActual.value=pagina+1;

    //metodo generico para mostrar las incidencias
    generarUsuarios(datosPaginacion);
}

//metodo para ir a la pagina anterior
function paginaAnterior()
{
    //variable temporal para guardar el numero de pagina
    let pajTemp=pagina;

    //compruebo que la pagina -1 no sea menor a -1
    if(--pajTemp>-1)
    {
        //resto en uno la pagina
        pagina--;

        //mostrar en el input la pagina actual
        paginaActual.value=pagina+1;

        //metodo generico para mostrar las incidencias
        generarUsuarios(datosPaginacion);
    }
}

//metodo que mostra la pgina que se escriba en el input
function paginaEscrita()
{
    //comprueba que el valor del inpu sea un numero entre 0 y el tamaño de las paginas posibles
    if(paginaActual.value>0 && paginaActual.value<=datosPaginacion.length)
    {
        //le doy el valor del input a la pagina
        pagina=paginaActual.value-1;

        //metodo generico para mostrar las incidencias
        generarUsuarios(datosPaginacion);
    }
}

//metodo para ir a la pagina siguiente
function paginaSiguiente()
{
    //guardo la pagina actual en una variable temporal
    let pajTemp=pagina;

    //compruebo que la pagina +1 no sea mayor al total de las paginas
    if(++pajTemp<datosPaginacion.length)
    {
        //sumo la pagina
        pagina++;

        //muestro a traves del input la pagina actual
        paginaActual.value=pagina+1;

        //metodo generico para mostrar las incidencias
        generarUsuarios(datosPaginacion);
    }
}

//metodo para ir a la ultima pagina
function paginacionFin()
{
    //le doy el valor de la ultima pagina a la variable pagina
    pagina=datosPaginacion.length-1;

    //muestro a traves del input la pagina actual
    paginaActual.value=pagina+1;

    //metodo generico para mostrar las incidencias
    generarUsuarios(datosPaginacion);
}

//metodo para filtroar por nombre de usuario
function filtroUsuarioTemp(datosFiltrados,nombreInput)
{
    //filtro el usuario por su nombre de usuario
    return datosFiltrados.filter(item =>
        item.usuario.toLowerCase().includes(nombreInput.toLowerCase())
    );
}

//metodo para filtroar por nombre completo
function filtroNombreCompletoTemp(datosFiltrados,nombrCompletoeInput)
{
    //filtro el usuario por su nombre completo
    return datosFiltrados.filter(item =>
        item.nombre_completo.toLowerCase().includes(nombrCompletoeInput.toLowerCase())
    );
}

//metodo para filtrar por email
function filtroEmailTemp(datosFiltrados,emailInput)
{
    let usuarios=[];

    for(let i=0;i<datosFiltrados.length;i++)
    {
        //console.log(datosFiltrados[i]);
        if(datosFiltrados[i].email!=null)
        {
            if(datosFiltrados[i].email.includes(emailInput.toLowerCase()))
            {
                usuarios.push(datosFiltrados[i]);
            }
        }
    }

    return usuarios;
}

function aplicacionFiltros()
{
    //objeto para sarle los criterios de filtrado
    let criterios={};
    //primer array de datos filtrados de valores estaricos (selects)
    let filtrados=[];
    //segundo array de datos filtrados por nombre de usuario
    let filtradosNombreusuario=[];
    //segundo array de datos filtrados por nombre completo
    let filtradosNombreCompleto=[];
    //segundo array de datos filtrados por email
    let filtradosEmail=[];
    //array final de datos filtrados
    datosFinales=[];


    if(departamentoFiltro.value!="-1")
    {
        criterios.departamento=departamentoFiltro.value;
    }

    if(rolFiltro.value!="-1")
    {
        let rol=[rolFiltro.value];
        criterios.roles=rol;
    }

    //console.log(criterios);
    //guardo las incidencias que esten filtrado en esta variable
    filtrados=filtrarObjetos(datosUsuarios,criterios);
    console.log(filtrados);

    if(nombreUsuarioFiltro.value!="")
    {
        filtradosNombreusuario=filtroUsuarioTemp(filtrados,nombreUsuarioFiltro.value);
    }

    if(nombreCompletoFiltro.value!="")
    {
        if(filtradosNombreusuario.length>0)
        {
            filtradosNombreCompleto=filtroNombreCompletoTemp(filtradosNombreusuario,nombreCompletoFiltro.value);
        }
        else
        {
            filtradosNombreCompleto=filtroNombreCompletoTemp(filtrados,nombreCompletoFiltro.value);
        }
    }

    //pregunto si el input de email tiene valor para hacer el filtro o no
    if(emailFiltro.value!="")
    {
        if(filtradosNombreusuario.length>0 && filtradosNombreCompleto.length>0)
        {
            filtradosEmail=filtroEmailTemp(filtradosNombreusuario,emailFiltro.value);
        }
        else if(filtradosNombreusuario.length>0 && filtradosNombreCompleto.length<0)
        {
            filtradosEmail=filtroEmailTemp(filtradosNombreusuario,emailFiltro.value);
        }
        else
        {
            filtradosEmail=filtroEmailTemp(filtrados,emailFiltro.value);
        }
    }

    //pregunto en donde estan los datos filtrados para poder guardarlos en otra variable final
    if(filtrados.length>0 && filtradosNombreusuario.length==0 && filtradosNombreCompleto.length==0 && filtradosEmail.length==0)
    {
        datosFinales=filtrados;
    }
    else if(filtrados.length>0 && filtradosNombreusuario.length>0 && filtradosNombreCompleto.length==0 && filtradosEmail.length==0)
    {
        datosFinales=filtradosNombreusuario;
    }
    else if(filtrados.length>0 && filtradosNombreusuario.length==0 && filtradosNombreCompleto.length>0 && filtradosEmail.length==0)
    {
        datosFinales=filtradosNombreCompleto;
    }
    else if(filtrados.length>0 && filtradosNombreusuario.length>0 && filtradosNombreCompleto.length>0 && filtradosEmail.length==0)
    {
        datosFinales=filtradosNombreCompleto;
    }
    else if(filtrados.length>0 && filtradosNombreusuario.length>0 && filtradosNombreCompleto.length>0 && filtradosEmail.length>0)
    {
        datosFinales=filtradosEmail;
    }
    else if(filtrados.length>0 && filtradosNombreusuario.length==0 && filtradosNombreCompleto.length==0 && filtradosEmail.length>0)
    {
        datosFinales=filtradosEmail;
    }

    //console.log(datosFinales);

    //pongo la pagina a 0 y el valor del input a la primera pagina
    pagina=0;
    paginaActual.value=1;

    //metodo para crear el array de paginacion pero con los datos filtrados
    crearArrayPaginacion(datosFinales);

    //metodo generico para mostrar las incidencias
    generarUsuarios(datosPaginacion);
}

function borrarFiltros()
{
    //poner todos los inputs y select a valor por defecto y quitar los valores del select de subtipos
    nombreUsuarioFiltro.value="";
    nombreCompletoFiltro.value="";
    emailFiltro.value="";
    departamentoFiltro.value="-1";
    rolFiltro.value="-1";
    datosFinales=[];

    //poner la pagina 1
    pagina=0;
    paginaActual.value=1;

    //creo el array de paginacion con todos los datos
    crearArrayPaginacion(datosUsuarios);

    //metodo generico para mostrar las incidencias
    generarUsuarios(datosPaginacion);
}

// Funcion para filtrado de atributos estaticos
function filtrarObjetos(objetos, criterios)
{
    //recorro el array de todo y devolviendo un array filtrado
    return objetos.filter(objeto =>
        {
            //recorro las propiedades
            for (let propiedad in criterios)
            {
                if(propiedad =="roles")
                {
                    if(criterios[propiedad][0]==objeto.roles[0])
                    {
                        continue;
                    }
                }

                //comparo si esta indefinida para que pase a la siguiente
                if (criterios[propiedad] === undefined)
                {
                    continue;
                }

                if (objeto[propiedad] !== criterios[propiedad]) {
                  return false;
                }
            }

            return true;
        }
    );
}

//metodo generica para poder mosrtrar los usuarios
function generarUsuarios(datos)
{
    //vacio el contenedor de incidencias
    document.querySelector("#contenedorUsuarios").innerHTML="";
    let ruta=host+"/usuarios";
    //recorr el array de paginacion en la pagina que tenga el valor de pagina
    for(let i=0;datos[pagina].length;i++)
    {
        //ruta para la vista de edit de esa incidencia
        let stringRedirect=ruta+"/"+datos[pagina][i].usuario+"/edit";

        //creo el div padre de la incidencia y le doy las clases necesarias
        let divPadre=document.createElement("div");//contenedor de la incidencia
        divPadre.classList="lista-incidencias";

        //creo el div intero al padre de la incidencia y le doy las clases necesarias
        let divPadreIntero=document.createElement("div");//div interno a la incidcencia
        divPadreIntero.classList="row d-flex justify-content-between align-items-center flex-nowrap rounded";

        //creo el div del id de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divNombreUsuario=document.createElement("div");//id
        divNombreUsuario.classList="col p-3 text-ellipsis";
        divNombreUsuario.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div del nombre de usuario de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divNombreCompleto=document.createElement("div");//usuario
        divNombreCompleto.classList="col p-3 text-ellipsis";
        divNombreCompleto.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div del tipo de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divEmail=document.createElement("div");//tipo
        divEmail.classList="col p-3 text-ellipsis";
        divEmail.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div del subtipo de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divNombreDepartamento=document.createElement("div");//subtipo
        divNombreDepartamento.classList="col p-3 text-ellipsis";
        divNombreDepartamento.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div de la fecha de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divRol=document.createElement("div");
        divRol.classList="col p-3 baja-res";
        divRol.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div de los botones y le doy las clases necesarias
        let divBotones=document.createElement("div");//botones
        divBotones.classList="col p-3 movil-res";

        //creo el div interno de los botones y le doy las clases necesarias
        let divBotonesInterno=document.createElement("div");//div interno a los botones
        divBotonesInterno.classList="d-flex flex-column justify-content-center gap-2";

        //creo los textos de los divs
        let textNombreUsuarios=document.createTextNode(datos[pagina][i].usuario);//id
        let textNombreCompleto=document.createTextNode(datos[pagina][i].nombre_completo);//usuario
        let textEmail=document.createTextNode(datos[pagina][i].email);//tipo
        let textNombreDepartamento=document.createTextNode(datos[pagina][i].departamento);//subtipo
        let textRol=document.createTextNode(datos[pagina][i].roles[0]);

        //creo el boton de detaller y le doy las clases y la ruta
        let aDetalles=document.createElement("a");
        aDetalles.innerHTML="Detalles";
        aDetalles.type="button";
        aDetalles.href=stringRedirect;
        aDetalles.classList="btn aquamarine-400 text-white";

        //meto el boton de detalles
        divBotonesInterno.appendChild(aDetalles);

        //meto los textos del usuario dentro del sus divs
        divNombreUsuario.appendChild(textNombreUsuarios);
        divNombreCompleto.appendChild(textNombreCompleto);
        divEmail.appendChild(textEmail);
        divNombreDepartamento.appendChild(textNombreDepartamento);
        divRol.appendChild(textRol);
        divBotones.appendChild(divBotonesInterno);

        //meto los divs de la informacion del usuario y los botones dentro del divPadreInerno
        divPadreIntero.appendChild(divNombreUsuario);
        divPadreIntero.appendChild(divNombreCompleto);
        divPadreIntero.appendChild(divEmail);
        divPadreIntero.appendChild(divNombreDepartamento);
        divPadreIntero.appendChild(divRol);
        divPadreIntero.appendChild(divBotones);

        //meto el divPadreInterno dentro del div padre
        divPadre.appendChild(divPadreIntero);

        //meto la incidencia dentro del contenedor de incidencias
        document.querySelector("#contenedorUsuarios").appendChild(divPadre);

        //pregunto si estoy en la primera pagina
        if(pagina==0)
        {
            //al ser la pagina 0 anterior esta desavilitado y sus clases
            inicioPaginacion.disabled=true;
            inicioPaginacion.parentNode.classList="page-item disabled";

            //al ser la pagina 0 anterior esta desavilitado y sus clases
            anterior.disabled=true;
            anterior.parentNode.classList="page-item disabled";

            //al ser la pagina 0 siguiente esta avilitado y sus clases
            siguiente.disabled=false;
            siguiente.parentNode.classList="page-item";

            //al ser la pagina 0 final esta avilitado y sus clases
            finalPaginacion.disabled=false;
            finalPaginacion.parentNode.classList="page-item";

        }

        //pregunto si estoy en la ultima pagina
        if(pagina==datos.length-1)
        {
            //al ser la ultima pagina inicio esta avilitado y sus clases
            inicioPaginacion.disabled=false;
            inicioPaginacion.parentNode.classList="page-item";


            //al ser la ultima pagina anterior esta avilitado y sus clases
            anterior.disabled=false;
            anterior.parentNode.classList="page-item";

            //al ser la ultima pagina siguiente esta desavilitado y sus clases
            siguiente.disabled=true;
            siguiente.parentNode.classList="page-item disabled";

            //al ser la ultima pagina final esta desavilitado y sus clases
            finalPaginacion.disabled=true;
            finalPaginacion.parentNode.classList="page-item disabled";

        }

        //pregunto si estoy en una pagina que no sea ni la ultima ni la primera para que esnte todas las opciones disponibles
        if(pagina>0 && pagina<datos.length-1)
        {
            inicioPaginacion.disabled=false;
            inicioPaginacion.parentNode.classList="page-item";

            anterior.disabled=false;
            anterior.parentNode.classList="page-item";

            siguiente.disabled=false;
            siguiente.parentNode.classList="page-item";

            finalPaginacion.disabled=false;
            finalPaginacion.parentNode.classList="page-item";

        }

        //al lado del input escribo el numero total de paginas que hay disponibles para ver
        paginasTotales.innerHTML=""
        paginasTotales.innerHTML+=datos.length;
    }
}

function redirect(url)
{
    window.location.href=url;
}
