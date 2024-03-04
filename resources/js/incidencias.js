/**
 * Event listener que se ejecuta cuando la página se carga por completo.
 * Llama a la función 'inicio'.
 *
 * @event load
 */
addEventListener("load",inicio,false);

/**
 * Variable que almacena los datos de incidencias.
 *
 * @type {Array}
 * @name datosIncidencias
 */
let datosIncidencias;

/**
 * Variable que almacena el rol.
 *
 * @type {string}
 * @name rol
 */
let rol;

/**
 * Arreglo que almacena los datos finales después de aplicar filtros.
 *
 * @type {Array}
 * @name datosFinales
 */
let datosFinales=[];

/**
 * Arreglo que almacena los datos de paginación.
 *
 * @type {Array}
 * @name datosPaginacion
 */
let datosPaginacion=[];

/**
 * Variable que representa la página actual en la paginación.
 *
 * @type {number}
 * @name pagina
 */
let pagina=0;

/**
 * Host del servidor para las conexiones.
 *
 * @type {string}
 * @name host
 */
import {hostServer} from "./variableHost.js";
let host=hostServer;

/**
 * Función que inicia la aplicación.
 * Realiza la llamada AJAX para obtener las incidencias y muestra la información en la interfaz.
 * Además, configura los eventos para filtros y paginación.
 */
function inicio()
{
    //llamada de ajax y creacion de las incidencias en el html
    obtenerIncidencias().then(data => {
        datosIncidencias = data.incidencias; // Guardamos los datos en la variable
        rol=data.rol_usuario[0];
        //console.log(data);

        crearArrayPaginacion(datosIncidencias);
        if(rol=="administrador")
        {
            //metodo generico para mostrar las incidencias para el edministrador
            generarIncidenciasAdmi(datosPaginacion);
        }
        else
        {
            generarIncidenciasUsuario(datosPaginacion);
        }
    });

    //llamadas a los metodos para los filtros
    filtrar.addEventListener("click",aplicacionFiltros,false);
    borrar.addEventListener("click",borrarFiltros,false);
    tipoFiltro.addEventListener("change",generarSubtipos,false);

    //llamadas a los metodos para la paginacion
    inicioPaginacion.addEventListener("click",paginacionInicio,false);
    anterior.addEventListener("click",paginaAnterior,false);
    paginaActual.addEventListener("keyup",paginaEscrita,false);
    siguiente.addEventListener("click",paginaSiguiente,false);
    finalPaginacion.addEventListener("click",paginacionFin,false);

    //llamada a la pregunta del borrado
    //activarBorrado.addEventListener("click",confiramarBorrado,false);
}

/**
 * Función asincrónica para obtener datos de incidencias mediante una llamada a una ruta en Laravel.
 * @returns {Promise<Object>} Una promesa que se resuelve con los datos de incidencias obtenidos.
 * @throws {Error} Error HTTP si la respuesta no es exitosa.
 */
async function obtenerIncidencias()
{
    try
    {
        let ruta=host+"/datos";
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

/**
 * Función para crear un array paginado a partir de un array de entrada.
 * @param {Array} array - El array de entrada que se dividirá en páginas.
 */
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

/**
 * Función para establecer la página actual en el inicio y mostrar las incidencias correspondientes.
 */
function paginacionInicio()
{
    //colocar la variable pagina a 0 para que sea la primea pagina en mostrarse
    pagina=0;

    //mostrar en el input la pagina actual
    paginaActual.value=pagina+1;

    if(rol=="administrador")
    {
        //metodo generico para mostrar las incidencias para el edministrador
        generarIncidenciasAdmi(datosPaginacion);
    }
    else
    {
        generarIncidenciasUsuario(datosPaginacion);
    }
}

/**
 * Función para cambiar a la página anterior y mostrar las incidencias correspondientes.
 */
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

        if(rol=="administrador")
        {
            //metodo generico para mostrar las incidencias para el edministrador
            generarIncidenciasAdmi(datosPaginacion);
        }
        else
        {
            generarIncidenciasUsuario(datosPaginacion);
        }
    }
}

/**
 * Función para cambiar a la página escrita en el input y mostrar las incidencias correspondientes.
 */
function paginaEscrita()
{
    //comprueba que el valor del inpu sea un numero entre 0 y el tamaño de las paginas posibles
    if(paginaActual.value>0 && paginaActual.value<=datosPaginacion.length)
    {
        //le doy el valor del input a la pagina
        pagina=paginaActual.value-1;

        if(rol=="administrador")
        {
            //metodo generico para mostrar las incidencias para el edministrador
            generarIncidenciasAdmi(datosPaginacion);
        }
        else
        {
            generarIncidenciasUsuario(datosPaginacion);
        }
    }
}

/**
 * Función para cambiar a la página siguiente y mostrar las incidencias correspondientes.
 */
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

        if(rol=="administrador")
        {
            //metodo generico para mostrar las incidencias para el edministrador
            generarIncidenciasAdmi(datosPaginacion);
        }
        else
        {
            generarIncidenciasUsuario(datosPaginacion);
        }
    }
}

/**
 * Función para cambiar a la última página y mostrar las incidencias correspondientes.
 */
function paginacionFin()
{
    //le doy el valor de la ultima pagina a la variable pagina
    pagina=datosPaginacion.length-1;

    //muestro a traves del input la pagina actual
    paginaActual.value=pagina+1;

    if(rol=="administrador")
    {
        //metodo generico para mostrar las incidencias para el edministrador
        generarIncidenciasAdmi(datosPaginacion);
    }
    else
    {
        generarIncidenciasUsuario(datosPaginacion);
    }
}

/**
 * Función para generar dinámicamente los subtipos basados en el tipo seleccionado y actualizar el select.
 */
function generarSubtipos()
{
    //escribir el primer option del select
    subtipoFiltro.innerHTML="<option selected value='-1'>Selecciona el subtipo</option>";
    //creacion del array para los valores de los option
    let array=[];

    //switch para poder asignar los valores al array segun el tipo
    switch (tipoFiltro.value)
    {
        case "CUENTAS":
            array = ["EDUCANTABRIA","GOOGLE CLASSROOM","DOMINIO","YEDRA"];
            break;
        case "EQUIPOS":
            array = ["ALTAVOCES","PC","MONITOR","PROYECTOR","PANTALLA INTERACTIVA","PORTATIL","IMPRESORAS"];
            break;
        case "WIFI":
            array = ["IESMIGUELHERRERO","WIECAN"];
            break;
        case "INTERNET":
            array = [];
            break;
        case "SOFTWARE":
            array = ["INSTALACION","ACTUALIZACION"];
            break;
    }

    //for para poder crear los option del select
    for (let i=0;i<array.length;i++)
    {
        //creacion de option
        let opt=document.createElement("option");

        //añadirle el valor y el texto
        opt.textContent=array[i];
        opt.value=array[i];

        //agregar el option al select
        subtipoFiltro.appendChild(opt);
    }
}

/**
 * Función para filtrar un array de objetos basándose en un conjunto de criterios.
 * @param {Array} objetos - El array de objetos que se filtrará.
 * @param {Object} criterios - Objeto que contiene los criterios de filtrado.
 * @returns {Array} Un nuevo array que contiene solo los objetos que cumplen con los criterios de filtrado.
 */
function filtrarObjetos(objetos, criterios)
{
    //recorro el array de todo y devolviendo un array filtrado
    return objetos.filter(objeto =>
        {
            //recorro las propiedades
            for (let propiedad in criterios)
            {
                //comparo si esta indefinida para que pase a la siguiente
                if (criterios[propiedad] === undefined)
                {
                    continue;
                }

                // comparo por si la propiedad es un subtipo
                if (propiedad === "subtipo")
                {
                    if (criterios[propiedad].id !== undefined && objeto.subtipo.id !== criterios[propiedad].id)
                    {
                        return false;
                    }

                    if (criterios[propiedad].subtipo_nombre !== undefined && objeto.subtipo.subtipo_nombre !== criterios[propiedad].subtipo_nombre)
                    {
                        return false;
                    }

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

/**
 * Función para obtener el nombre completo de una persona a partir de sus componentes.
 * @param {Object} creador - Objeto que contiene las partes del nombre (nombre, apellido1, apellido2).
 * @returns {string} El nombre completo de la persona.
 */
function obtenerNombreCompleto(creador)
{
    return `${creador.nombre} ${creador.apellido1} ${creador.apellido2}`;
}

/**
 * Función para filtrar un array de objetos basándose en el nombre completo del creador.
 * @param {Array} objetosFiltrados - El array de objetos que se filtrará.
 * @param {string} nombre - Nombre del creador a filtrar.
 * @param {string} apellido1 - Primer apellido del creador a filtrar.
 * @param {string} apellido2 - Segundo apellido del creador a filtrar.
 * @returns {Array} Un nuevo array que contiene solo los objetos cuyo creador coincide con los datos proporcionados.
 */
function filtrarPorUsuario(objetosFiltrados, nombre, apellido1, apellido2)
{
    //recorro el array y devuevo otro pero filtrado
    return objetosFiltrados.filter(objeto =>
        {
            //obtengo el creador
            let creador = objeto.creador;

            //devuelvo la incidencia si el creador de la misma es el mismo por el que preguntan
            return(
                creador.nombre.toLowerCase().includes(nombre.toLowerCase()) &&
                creador.apellido1.toLowerCase().includes(apellido1.toLowerCase()) &&
                creador.apellido2.toLowerCase().includes(apellido2.toLowerCase())
            );
        }
    );
}

/**
 * Función para filtrar un array de objetos basándose en el nombre completo del creador.
 * @param {Array} datosFiltrados - El array de objetos que se filtrará.
 * @param {string} nombreInput - Nombre del creador a filtrar.
 * @returns {Array} Un nuevo array que contiene solo los objetos cuyo creador coincide con el nombre proporcionado.
 */
function filtroUsuarioTemp(datosFiltrados,nombreInput)
{
    //devuelvo la incidencia si el creador de la misma es el mismo por el que preguntan
    return datosFiltrados.filter
    (item =>
        //obtenerNombreCompleto(item.creador).toLowerCase().includes(nombreInput.toLowerCase())
        item.creador.nombre_completo.toLowerCase().includes(nombreInput.toLowerCase())
    );
}

/**
 * Función para filtrar un array de objetos basándose en la fecha de creación.
 * @param {Array} datos - El array de objetos que se filtrará.
 * @param {string} fechaDesde - Fecha desde la cual se realizará el filtro (en formato de cadena "YYYY-MM-DD").
 * @param {string} [fechaHasta=""] - Fecha hasta la cual se realizará el filtro (en formato de cadena "YYYY-MM-DD").
 * @returns {Array} Un nuevo array que contiene solo los objetos cuya fecha de creación coincide con el rango proporcionado.
 */
function filtroFecha(datos,fechaDesde,fechaHasta="")
{
    //compruevo que la fehca hasta este vacia
    if(fechaHasta=="")
    {
        //creo un objeto fecha
        let fechaBusqueda = new Date(fechaDesde);

        //filtro si la incidencia tiene como fecha la de busqueda
        return datos.filter(item =>
            {
                //creo un objeto date de la incidencia
                let fechaItem = new Date(item.fecha_creacion);

                //devuelvo la incidencia si la fecha es la misma
                return (fechaBusqueda.getDate()===fechaItem.getDate() && fechaBusqueda.getMonth()===fechaItem.getMonth() && fechaBusqueda.getFullYear()===fechaItem.getFullYear());
            }
        );
    }
    else
    {
        //creo los objetos date de la fecha hasta y la de desde
        let fechaBusquedaDesde=new Date(fechaDesde);
        let fechaBusquedaHasta=new Date(fechaHasta);

        //filtro si la incidencia tiene como fecha de creacion entre las dos dadas
        return datos.filter(item =>
            {
                //creo el objeto fecha de la incidencia
                let fechaItem = new Date(item.fecha_creacion);

                //devuelvo la incidencia si la fecha esta entre las dos dadas
                return (
                    fechaBusquedaDesde.getFullYear()<=fechaItem.getFullYear() && fechaBusquedaHasta.getFullYear()>=fechaItem.getFullYear() &&
                    (fechaBusquedaDesde.getFullYear()<fechaItem.getFullYear() || (fechaBusquedaDesde.getFullYear()===fechaItem.getFullYear() && fechaBusquedaDesde.getMonth()<=fechaItem.getMonth())) &&
                    (fechaBusquedaDesde.getFullYear()<fechaItem.getFullYear() || (fechaBusquedaDesde.getFullYear()===fechaItem.getFullYear() && fechaBusquedaDesde.getMonth()===fechaItem.getMonth() && fechaBusquedaDesde.getDate()<=fechaItem.getDate()))
                );
            }
        );
    }
}

/**
 * Función para aplicar filtros a las incidencias según los criterios proporcionados.
 */
function aplicacionFiltros()
{
    //objeto para sarle los criterios de filtrado
    let criterios={};
    //primer array de datos filtrados de valores estaricos (selects)
    let filtrados=[];
    //segundo array de datos filtrados por nombre de creador
    let filtradosNombre=[];
    //tercer array de datos filtrados por fecha
    let filtradosFecha=[];
    //array final de datos filtrados
    datosFinales=[];

    //si solo esta la fecha desde con valor no se aplican filtros y se indica al usuario
    if(fechaDesdeFiltro.value=="" && fechaHastaFiltro.value!="")
    {
        //mensaje para el usuario
        alert("la fecha como minimo hay que poner desde cuando hay que buscar");
        return;
    }

    if(rol=="administrador")
    {
        //pregunta para saber si hay que filtrar por id
        if(idFiltro.value!="")
        {
            criterios.id=parseInt(idFiltro.value);
        }
    }

    //pregunta para saber si hay que filtrar por el tipo de filtro
    if(tipoFiltro.value!="-1")
    {
        criterios.tipo=tipoFiltro.value;
    }

    //pregunta para saber si hay que filtrar por el subfiltro del tipo
    if(subtipoFiltro.value!="-1")
    {
        let subtipo={subtipo_nombre:subtipoFiltro.value};
        criterios.subtipo=subtipo;
    }

    //pregunta para saber si hay que filtrar por prioridad
    if(prioridadFiltro.value!="-1")
    {
        criterios.prioridad=prioridadFiltro.value;
    }

    //pregunta para saber si hay que filtrar por estado
    if(estadoFiltro.value!="-1")
    {
        criterios.estado=estadoFiltro.value;
    }

    //preguntar para saver si hay que filtrar por responsable de la incidencia
    if(responsableFiltro.value!="-1")
    {
        criterios.responsable_id=parseInt(responsableFiltro.value);
    }

    //console.log(criterios);
    //guardo las incidencias que esten filtrado en esta variable
    filtrados=filtrarObjetos(datosIncidencias,criterios);
    //console.log(filtrados);

    if(rol=="administrador")
    {
            //pregunta para saber si hay que filtrar por nombre del creador
        if(nombreFiltro.value!="")
        {
            //guardo las incidencias filtradas, y tambien por nombre
            filtradosNombre=filtroUsuarioTemp(filtrados,nombreFiltro.value);
            //console.log(filtradosNombre);
        }
    }

    //pregunta para saber si hay que filtrar por fecha en est caso solo por un dia en conreto
    if(fechaDesdeFiltro.value!="" && fechaHastaFiltro.value=="")
    {

        if(filtradosNombre.length==0 && filtrados.length==0)
        {
            filtradosFecha=filtroFecha(datosIncidencias,fechaDesdeFiltro.value);
            //console.log(filtradosFecha);
        }
        else if(filtrados.length>0 && filtradosNombre.length==0)
        {
            filtradosFecha=filtroFecha(filtrados,fechaDesdeFiltro.value);
            //console.log(filtradosFecha);
        }
        else if(filtrados.length>0 && filtradosNombre.length>0)
        {
            filtradosFecha=filtroFecha(filtradosNombre,fechaDesdeFiltro.value);
            //console.log(filtradosFecha);
        }

    }
    //pregunta para saber si hay que filtrar por fecha, en este caso por un intervalo de fechas
    else if(fechaDesdeFiltro.value!="" && fechaHastaFiltro.value!="")
    {
        if(filtradosNombre.length==0 && filtrados.length==0)
        {
            filtradosFecha=filtroFecha(datosIncidencias,fechaDesdeFiltro.value,fechaHastaFiltro.value);
            //console.log(filtradosFecha);
        }
        else if(filtrados.length>0 && filtradosNombre.length==0)
        {
            filtradosFecha=filtroFecha(filtrados,fechaDesdeFiltro.value,fechaHastaFiltro.value);
            //console.log(filtradosFecha);
        }
        else if(filtrados.length>0 && filtradosNombre.length>0)
        {
            filtradosFecha=filtroFecha(filtradosNombre,fechaDesdeFiltro.value,fechaHastaFiltro.value);
            //console.log(filtradosFecha);
        }
    }

    //pregunto en donde estan los datos filtrados para poder guardarlos en otra variable final
    if(filtrados.length>0 && filtradosNombre.length==0 && filtradosFecha.length==0)
    {
        datosFinales=filtrados;
    }
    else if(filtrados.length>0 && filtradosNombre.length>0 && filtradosFecha.length==0)
    {
        datosFinales=filtradosNombre;
    }
    else if(filtrados.length>0 && filtradosNombre.length==0 && filtradosFecha.length>0)
    {
        datosFinales=filtradosFecha;
    }
    else if(filtrados.length>0 && filtradosNombre.length>0 && filtradosFecha.length>0)
    {
        datosFinales=filtradosFecha;
    }

    //console.log(datosFinales);

    //pongo la pagina a 0 y el valor del input a la primera pagina
    pagina=0;
    paginaActual.value=1;

    //metodo para crear el array de paginacion pero con los datos filtrados
    crearArrayPaginacion(datosFinales);

    //pregunta para poder usar un metodo u otro en funcion del rol
    if(rol=="administrador")
    {
        //metodo generico para mostrar las incidencias para el administrador
        generarIncidenciasAdmi(datosPaginacion);
    }
    else
    {
        //metodo generico para mostrar las incidencias para el profesor
        generarIncidenciasUsuario(datosPaginacion);
    }

}

/**
 * Función para restablecer todos los filtros y valores a sus configuraciones predeterminadas.
 */
function borrarFiltros()
{
    //poner todos los inputs y select a valor por defecto y quitar los valores del select de subtipos
    if(rol=="administrador")
    {
        idFiltro.value="";
        nombreFiltro.value="";
    }
    tipoFiltro.value="-1";
    subtipoFiltro.value="-1";
    generarSubtipos();
    prioridadFiltro.value="-1";
    fechaDesdeFiltro.value="";
    fechaHastaFiltro.value="";
    estadoFiltro.value="-1";
    responsableFiltro.value="-1";
    datosFinales=[];

    //poner la pagina 1
    pagina=0;
    paginaActual.value=1;

    //creo el array de paginacion con todos los datos
    crearArrayPaginacion(datosIncidencias);

    if(rol=="administrador")
    {
        //metodo generico para mostrar las incidencias para el edministrador
        generarIncidenciasAdmi(datosPaginacion);
    }
    else
    {
        generarIncidenciasUsuario(datosPaginacion);
    }
}

/**
 * Genera la representación visual de las incidencias para el administrador.
 * @param {Array} datos - Array de incidencias a mostrar.
 */
function generarIncidenciasAdmi(datos)
{
    //comprovacion para la creacion de las graficas con datos filtrados o todos
    if(datosFinales.length>0)
    {
        //metodos para crear grafico circular y sus datos
        crearGraficaTipos(datosTipo(datosFinales));

        //metodo para crear grafica de barras y sus datos
        crearGraficaEstado(datosEstado(datosFinales));

        crearGraficaTipomMedio(datosTiempoMedio(datosFinales));
    }
    else
    {
        //metodos para crear grafico circular y sus datos
        crearGraficaTipos(datosTipo(datosIncidencias));

        //metodo para crear grafica de barras y sus datos
        crearGraficaEstado(datosEstado(datosIncidencias));

        crearGraficaTipomMedio(datosTiempoMedio(datosIncidencias));
    }

    //vacio el contenedor de incidencias
    document.querySelector("#contenedorIncidencias").innerHTML="";
    let ruta=host+"/incidencias";
    //recorr el array de paginacion en la pagina que tenga el valor de pagina
    for(let i=0;i<datos[pagina].length;i++)
    {
        //ruta para la vista de show de esa incidencia
        let stringRedirect=ruta+"/"+datos[pagina][i].id;

        //creo el div padre de la incidencia y le doy las clases necesarias
        let divPadre=document.createElement("div");//contenedor de la incidencia
        divPadre.classList="lista-incidencias";

        //creo el div intero al padre de la incidencia y le doy las clases necesarias
        let divPadreIntero=document.createElement("div");//div interno a la incidcencia
        divPadreIntero.classList="row d-flex justify-content-between align-items-center flex-nowrap rounded";

        //creo el div del id de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divId=document.createElement("div");//id
        divId.classList="col p-3 baja-res";
        divId.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div del nombre de usuario de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divUsuario=document.createElement("div");//usuario
        divUsuario.classList="col p-3 baja-res";
        divUsuario.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div del tipo de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divTipoIncidencia=document.createElement("div");//tipo
        divTipoIncidencia.classList="col p-3 text-ellipsis";
        divTipoIncidencia.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div del subtipo de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divSubtipo=document.createElement("div");//subtipo
        divSubtipo.classList="col p-3 text-ellipsis";
        divSubtipo.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div de la fecha de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divFecha=document.createElement("div");
        divFecha.classList="col p-3 baja-res";
        divFecha.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div de la prioridad de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divPrioridad=document.createElement("div");//prioridad
        divPrioridad.classList="col p-3 text-ellipsis";
        divPrioridad.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div del id de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divEstado=document.createElement("div");//estado
        divEstado.classList="col p-3 text-ellipsis";
        divEstado.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div de los botones y le doy las clases necesarias
        let divBotones=document.createElement("div");//botones
        divBotones.classList="col p-3 movil-res";

        //creo el div interno de los botones y le doy las clases necesarias
        let divBotonesInterno=document.createElement("div");//div interno a los botones
        divBotonesInterno.classList="d-flex flex-column justify-content-center gap-2";

        //creo los textos de los divs
        let textId=document.createTextNode(datos[pagina][i].id);//id
        let textUsuario=document.createTextNode(datos[pagina][i].creador.nombre_completo);//usuario
        let textTipoIncidencia=document.createTextNode(datos[pagina][i].tipo);//tipo
        let textSubtipo=document.createTextNode(datos[pagina][i].tipo!="INTERNET"?datos[pagina][i].subtipo.subtipo_nombre:"N/A");//subtipo, si es internet pone n/a por que no tiene subtipos, si no el subtipo de la incidencia
        let textFecha=document.createTextNode(datos[pagina][i].fecha_creacion);//fecha de creacion de la incidencia
        let textPrioridad=document.createTextNode(datos[pagina][i].prioridad);//prioridad
        let textEstado=document.createTextNode(datos[pagina][i].estado);//estado

        //creo el boton de detaller y le doy las clases y la ruta para que funcione
        let aDetalles=document.createElement("a");
        aDetalles.innerHTML="Detalles";
        aDetalles.type="button";
        aDetalles.href=ruta+"/"+datos[pagina][i].id;
        aDetalles.classList="btn aquamarine-400 text-white";

        //creo el boton de borrado y le doy los valores y las clase y atributos para que funcione
        let inputBorrar=document.createElement("input");
        inputBorrar.value="Borrar";
        inputBorrar.type="button";
        inputBorrar.classList="btn btn-danger text-white flex-fill";
        inputBorrar.setAttribute("data-bs-toggle","modal");
        inputBorrar.setAttribute("data-bs-target","#staticBackdrop");
        inputBorrar.setAttribute("idincidencia",datos[pagina][i].id);
        inputBorrar.addEventListener("click",preguntarBorrado,false);

        //meto el boton de detalles
        divBotonesInterno.appendChild(aDetalles);
        //meto dentro del div de botones el boton de borrado
        divBotonesInterno.appendChild(inputBorrar);


        //meto los textos de la incidencia dentro del sus divs
        divId.appendChild(textId);
        divUsuario.appendChild(textUsuario);
        divTipoIncidencia.appendChild(textTipoIncidencia);
        divSubtipo.appendChild(textSubtipo);
        divFecha.appendChild(textFecha);
        divPrioridad.appendChild(textPrioridad);
        divEstado.appendChild(textEstado);
        divBotones.appendChild(divBotonesInterno);

        //meto los divs de la informacion de la incidencia y los botones dentro del divPadreInerno
        divPadreIntero.appendChild(divId);
        divPadreIntero.appendChild(divUsuario);
        divPadreIntero.appendChild(divTipoIncidencia);
        divPadreIntero.appendChild(divSubtipo);
        divPadreIntero.appendChild(divFecha);
        divPadreIntero.appendChild(divPrioridad);
        divPadreIntero.appendChild(divEstado);
        divPadreIntero.appendChild(divBotones);

        //meto el divPadreInterno dentro del div padre
        divPadre.appendChild(divPadreIntero);

        //meto la incidencia dentro del contenedor de incidencias
        document.querySelector("#contenedorIncidencias").appendChild(divPadre);

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
        //paginasTotales.innerHTML = "";
        paginasTotales.innerHTML=datos.length;
    }
}

/**
 * Genera la representación visual de las incidencias para el profesor.
 * @param {Array} datos - Array de incidencias a mostrar.
 */
function generarIncidenciasUsuario(datos)
{
    //console.log(datos[pagina]);
    //vacio el contenedor de incidencias
    document.querySelector("#contenedorIncidencias").innerHTML="";
    let ruta=host+"/incidencias";
    //recorr el array de paginacion en la pagina que tenga el valor de pagina
    for(let i=0;i<datos[pagina].length;i++)
    {
        //console.log(datos[pagina][i]);
        //ruta para la vista de show de esa incidencia
        let stringRedirect=ruta+"/"+datos[pagina][i].id;

        //creo el div padre de la incidencia y le doy las clases necesarias
        let divPadre=document.createElement("div");//contenedor de la incidencia
        divPadre.classList="lista-incidencias";

        //creo el div intero al padre de la incidencia y le doy las clases necesarias
        let divPadreIntero=document.createElement("div");//div interno a la incidcencia
        divPadreIntero.classList="row d-flex justify-content-between align-items-center flex-nowrap rounded";

        //creo el div del tipo de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divTipoIncidencia=document.createElement("div");//tipo
        divTipoIncidencia.classList="col p-3 text-ellipsis";
        divTipoIncidencia.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div del subtipo de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divSubtipo=document.createElement("div");//subtipo
        divSubtipo.classList="col p-3 text-ellipsis";
        divSubtipo.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div de la fecha de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divFecha=document.createElement("div");
        divFecha.classList="col p-3 baja-res";
        divFecha.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div de la prioridad de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divPrioridad=document.createElement("div");//prioridad
        divPrioridad.classList="col p-3 text-ellipsis";
        divPrioridad.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div del id de la incidencia y le doy las clases necesarias y el metodo para cuando haga click en el te rediriga a la vista show
        let divEstado=document.createElement("div");//estado
        divEstado.classList="col p-3 text-ellipsis";
        divEstado.addEventListener("click",()=>redirect(stringRedirect),false);

        //creo el div de los botones y le doy las clases necesarias
        let divBotones=document.createElement("div");//botones
        divBotones.classList="col p-3 movil-res";

        //creo el div interno de los botones y le doy las clases necesarias
        let divBotonesInterno=document.createElement("div");//div interno a los botones
        divBotonesInterno.classList="d-flex flex-column justify-content-center gap-2";

        //creo los textos de los divs
        let textTipoIncidencia=document.createTextNode(datos[pagina][i].tipo);//tipo
        let textSubtipo=document.createTextNode(datos[pagina][i].tipo!="INTERNET"?datos[pagina][i].subtipo.subtipo_nombre:"n/a");
        let textFecha=document.createTextNode(datos[pagina][i].fecha_creacion)//fecha de creacion
        let textPrioridad=document.createTextNode(datos[pagina][i].prioridad);//prioridad
        let textEstado=document.createTextNode(datos[pagina][i].estado);//estado

        //creo el boton de detaller y le doy las clases y la ruta para que funcione
        let aDetalles=document.createElement("a");
        aDetalles.innerHTML="Detalles";
        aDetalles.type="button";
        aDetalles.href=ruta+"/"+datos[pagina][i].id;
        aDetalles.classList="btn aquamarine-400 text-white";

        //meto el boton de detalles
        divBotonesInterno.appendChild(aDetalles);

        //los profesores solo pueden borrar si la incidencia esta abierta
        if(datos[pagina][i].estado=="ABIERTA")
        {
            //creo el boton de borrado y le doy los valores y las clase y atributos para que funcione
            let inputBorrar=document.createElement("input");
            inputBorrar.value="Borrar";
            inputBorrar.type="button";
            inputBorrar.classList="btn btn-danger text-white flex-fill";
            inputBorrar.setAttribute("data-bs-toggle","modal");
            inputBorrar.setAttribute("data-bs-target","#staticBackdrop");
            inputBorrar.setAttribute("idincidencia",datos[pagina][i].id);
            inputBorrar.addEventListener("click",preguntarBorrado,false);


            //meto dentro del div de botones el boton de borrado
            divBotonesInterno.appendChild(inputBorrar);
        }


        //meto los textos de la incidencia dentro del sus divs
        divTipoIncidencia.appendChild(textTipoIncidencia);
        divSubtipo.appendChild(textSubtipo);
        divFecha.appendChild(textFecha);
        divPrioridad.appendChild(textPrioridad);
        divEstado.appendChild(textEstado);
        divBotones.appendChild(divBotonesInterno);

        //meto los divs de la informacion de la incidencia y los botones dentro del divPadreInerno
        divPadreIntero.appendChild(divTipoIncidencia);
        divPadreIntero.appendChild(divSubtipo);
        divPadreIntero.appendChild(divFecha);
        divPadreIntero.appendChild(divPrioridad);
        divPadreIntero.appendChild(divEstado);
        divPadreIntero.appendChild(divBotones);

        //meto el divPadreInterno dentro del div padre
        divPadre.appendChild(divPadreIntero);

        //meto la incidencia dentro del contenedor de incidencias
        document.querySelector("#contenedorIncidencias").appendChild(divPadre);

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

/**
 * Calcula y devuelve un array bidimensional con los tipos de incidencias y su cantidad correspondiente.
 * Obtener los datos de los tipos de las incidencias en el formato adecuado para la grafica fircular
 * @param {Array} datos - Array de incidencias.
 * @returns {Array} - Array bidimensional con los tipos de incidencias y su cantidad.
 */
function datosTipo(datos)
{
    //varibles para contar el numero de incidencias
    let equpos=0;
    let cuentas=0;
    let wifi=0;
    let internet=0;
    let software=0;

    //recorro y cuento los tipos de incidencias
    datos.forEach(item => {

        if(item.tipo=="EQUIPOS")
        {
            equpos++;
        }
        else if(item.tipo=="CUENTAS")
        {
            cuentas++;
        }
        else if(item.tipo=="WIFI")
        {
            wifi++;
        }
        else if(item.tipo=="INTERNET")
        {
            internet++;
        }
        else if(item.tipo=="SOFTWARE")
        {
            software++;
        }
    });

    //devuelvo el array en el formato adecuado
    return [['Tipo', 'Numero de incidencias'],["Equipos",equpos],["Cuentas",cuentas],["Wifi",wifi],["Internet",internet],["Software",software]];
}

/**
 * Carga la librería de gráficos de Google y dibuja un gráfico circular (pie chart) con los datos proporcionados.
 *
 * @function
 * @name crearGraficaTipos
 * @param {Array} datos - Datos en formato adecuado para el gráfico circular.
 * @returns {void}
 */
function crearGraficaTipos(datos)
{
    google.charts.load('current', {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable(datos);
      /*var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Work',     11],
        ['Eat',      2],
        ['Commute',  2],
        ['Watch TV', 2],
        ['Sleep',    7]
      ]);*/

      let options = {
        title: 'Tipos de incidencias'
      };

      let chart = new google.visualization.PieChart(document.querySelector('#graficaTipos'));

      chart.draw(data, options);
    }
}

/**
 * Procesa los datos de incidencias para contar la cantidad de incidencias de cada tipo y estado,
 * devolviendo un array con el formato adecuado para la creación de la gráfica de barras.
 *
 * @function
 * @name datosEstado
 * @param {Array} datos - Datos de incidencias a procesar.
 * @returns {Array} - Datos en formato adecuado para la creación de la gráfica de barras.
 */
function datosEstado(datos)
{
    //arrays de los datos
    let equipos=["EQUIPOS",0,0,0,0,0,0];
    let cuentas=["CUENTAS",0,0,0,0,0,0];
    let wifi=["WIFI",0,0,0,0,0,0];
    let internet=["INTERNET",0,0,0,0,0,0];
    let software=["SOFTWARE",0,0,0,0,0,0];

    //recorro el array y cuento cuantas incidencias hay de cada tipo y de cada estado
    datos.forEach(item=>{

        if(item.tipo=="EQUIPOS")
        {
            if(item.estado=="ABIERTA")
            {
                equipos[1]++;
            }
            else if(item.estado=="CERRADA")
            {
                equipos[2]++;
            }
            else if(item.estado=="RESUELTA")
            {
                equipos[3]++;
            }
            else if(item.estado=="ASIGNADA")
            {
                equipos[4]++;
            }
            else if(item.estado=="ENVIADA A INFORTEC")
            {
                equipos[5]++;
            }
            else if(item.estado=="EN PROCESO")
            {
                equipos[6]++;
            }
        }
        else if(item.tipo=="CUENTAS")
        {
            if(item.estado=="ABIERTA")
            {
                cuentas[1]++;
            }
            else if(item.estado=="CERRADA")
            {
                cuentas[2]++;
            }
            else if(item.estado=="RESUELTA")
            {
                cuentas[3]++;
            }
            else if(item.estado=="ASIGNADA")
            {
                cuentas[4]++;
            }
            else if(item.estado=="ENVIADA A INFORTEC")
            {
                cuentas[5]++;
            }
            else if(item.estado=="EN PROCESO")
            {
                cuentas[6]++;
            }
        }
        else if(item.tipo=="WIFI")
        {
            if(item.estado=="ABIERTA")
            {
                wifi[1]++;
            }
            else if(item.estado=="CERRADA")
            {
                wifi[2]++;
            }
            else if(item.estado=="RESUELTA")
            {
                wifi[3]++;
            }
            else if(item.estado=="ASIGNADA")
            {
                wifi[4]++;
            }
            else if(item.estado=="ENVIADA A INFORTEC")
            {
                wifi[5]++;
            }
            else if(item.estado=="EN PROCESO")
            {
                wifi[6]++;
            }
        }
        else if(item.tipo=="INTERNET")
        {
            if(item.estado=="ABIERTA")
            {
                internet[1]++;
            }
            else if(item.estado=="CERRADA")
            {
                internet[2]++;
            }
            else if(item.estado=="RESUELTA")
            {
                internet[3]++;
            }
            else if(item.estado=="ASIGNADA")
            {
                internet[4]++;
            }
            else if(item.estado=="ENVIADA A INFORTEC")
            {
                internet[5]++;
            }
            else if(item.estado=="EN PROCESO")
            {
                internet[6]++;
            }
        }
        else if(item.tipo=="SOFTWARE")
        {
            if(item.estado=="ABIERTA")
            {
                software[1]++;
            }
            else if(item.estado=="CERRADA")
            {
                software[2]++;
            }
            else if(item.estado=="RESUELTA")
            {
                software[3]++;
            }
            else if(item.estado=="ASIGNADA")
            {
                software[4]++;
            }
            else if(item.estado=="ENVIADA A INFORTEC")
            {
                software[5]++;
            }
            else if(item.estado=="EN PROCESO")
            {
                software[6]++;
            }
        }
    });

    //devuelvo el array con el formato adecuado para la grafica de barras
    return [['','Abierta', 'Cerrada', 'Resuelta', 'Asignada', 'Enviada a infortec','En proceso'],equipos,cuentas,wifi,internet,software];
}

/**
 * Crea una gráfica de barras que representa el estado de las incidencias de diferentes tipos.
 * Para le creacion de grafica de barras que le paso un array con los datos en le formato del metodo anterior
 *
 * @function
 * @name crearGraficaEstado
 * @param {Array} datos - Datos en formato adecuado para la creación de la gráfica de barras.
 * @returns {void}
 */
function crearGraficaEstado(datos)
{
    google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
          /*var data = google.visualization.arrayToDataTable([
        ['Abierta', 'Cerrada', 'Resuelta', 'Asignada', 'Enviada a infortec',
         'En proceso',{ role: 'annotation' } ],
        ['Equipos', 10, 24, 20, 32, 18, 30],
        ['Cuentas', 16, 22, 23, 30, 16, 20],
        ['Wifi', 28, 19, 29, 30, 12, 40],
        ['Internet', 10, 24, 20, 32, 18, 30],
        ['Software', 16, 22, 23, 30, 16, 20]
      ]);*/
      let data=google.visualization.arrayToDataTable(datos);

      let view = new google.visualization.DataView(data);
      /*view.setColumns([0,1,2,3,4,5,6,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);*/
                       view.setColumns([0,1,2,3,4,5,6,
                        {
                            calc: "stringify",
                            sourceColumn: 0,
                            type: "string",
                            role: "annotation"}
                        ],2);

      let options = {
        width: 600,
        height: 400,
        legend: { position: 'top', maxLines: 5 },
        bar: { groupWidth: '75%' },
        isStacked: true
      };

      let chart = new google.visualization.BarChart(document.querySelector("#graficaEstasdo"));
      chart.draw(view, options);
      }
}

/**
 * Calcula el tiempo medio por incidencia para diferentes tipos de incidencias.
 * Para obtener los datos de el tiempo medio de duracion por tipo de incidencia en formato adecuado para la grafica fircular
 *
 * @function
 * @name datosTiempoMedio
 * @param {Array} datos - Datos de incidencias en formato adecuado para el cálculo del tiempo medio.
 * @returns {Array} - Matriz con el tiempo medio por incidencia para cada tipo de incidencia.
 */
function datosTiempoMedio(datos)
{
    //varibles para contar el numero de incidencias
    let equpos=0;
    let tiempoMedioEquipos=0;
    let cuentas=0;
    let tiempoMedioCuentas=0;
    let wifi=0;
    let tiempoMedioWifi=0;
    let internet=0;
    let tiempoMedioInternet=0;
    let software=0;
    let tiempoMedioSoftware=0;

    //recorro y cuento los tipos de incidencias
    datos.forEach(item => {

        //console.log(item.duracion)
        if(item.tipo=="EQUIPOS" && item.duracion!=null)
        {
            //console.log(item.duracion);
            equpos++;
            tiempoMedioEquipos+=item.duracion;
        }
        else if(item.tipo=="CUENTAS" && item.duracion!=null)
        {
            //console.log(item.duracion);
            cuentas++;
            tiempoMedioCuentas+=item.duracion;
        }
        else if(item.tipo=="WIFI" && item.duracion!=null)
        {
            //console.log(item.duracion);
            wifi++;
            tiempoMedioWifi+=item.duracion;
        }
        else if(item.tipo=="INTERNET" && item.duracion!=null)
        {
            //console.log(item.duracion);
            internet++;
            tiempoMedioInternet+=item.duracion;
        }
        else if(item.tipo=="SOFTWARE" && item.duracion!=null)
        {
            //console.log(item.duracion);
            software++;
            tiempoMedioSoftware+=item.duracion;
        }
    });

    //devuelvo el array en el formato adecuado
    return [['Tipo', 'Tiempo medio por incidencia'],["Equipos",tiempoMedioEquipos/equpos],["Cuentas",tiempoMedioCuentas/cuentas],["Wifi",tiempoMedioWifi/wifi],["Internet",tiempoMedioInternet/internet],["Software",tiempoMedioSoftware/software]];
}

/**
 * Crea una gráfica de pastel con el tiempo medio de incidencias para diferentes tipos.
 *
 * @function
 * @name crearGraficaTipomMedio
 * @param {Array} datos - Datos en formato adecuado para la creación de la gráfica.
 * @returns {void}
 */
function crearGraficaTipomMedio(datos)
{
    google.charts.load('current', {packages:['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable(datos);
      /*var data = google.visualization.arrayToDataTable([
        ['Task', 'Hours per Day'],
        ['Work',     11],
        ['Eat',      2],
        ['Commute',  2],
        ['Watch TV', 2],
        ['Sleep',    7]
      ]);*/

      let options = {
        title: 'Tiempo medio de incidencias'
      };

      let chart = new google.visualization.PieChart(document.querySelector('#graficaTiempoMedio'));

      chart.draw(data, options);
    }
}

//metodo para poder enviar a la ruta que se le pase
function redirect(url)
{
    window.location.href=url;
}

/**
 * Función que prepara y muestra un modal para confirmar el borrado de una incidencia.
 *
 * @function
 * @name preguntarBorrado
 * @param {Event} event - Evento que desencadena la función, generalmente un clic en un botón de borrado.
 * @returns {void}
 */
function preguntarBorrado(event)
{
    //coloco en el modal el valor del id de la incidencia
    numeroID.innerHTML=event.target.getAttribute("idincidencia");

    let ruta=host+"/incidencias/"+event.target.getAttribute("idincidencia");

    formBorrado.action=ruta;
}
