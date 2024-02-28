addEventListener("load",inicio,false);

let datosIncidencias;
let datosFinales;
let datosPaginacion=[];
let pagina=0;
let idFormularioBorrado="";

function inicio()
{
    //llamada de ajax y creacion de las incidencias en el html
    obtenerIncidencias().then(data => {
        datosIncidencias = data; // Guardamos los datos en la variable
        console.log(datosIncidencias); // Ahora deberías poder ver los datos

        crearArrayPaginacion(datosIncidencias);

        console.log(datosPaginacion);

        generarIncidencias(datosPaginacion);
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
    activarBorrado.addEventListener("click",confiramarBorrado,false);
}

//Funcion para obtener todas las incidencias a traves de ajax
async function obtenerIncidencias()
{
    try
    {
        //llamada a la ruta de laravel para obtener los datos
        let response = await fetch("http://127.0.0.1:8000/datos");
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
    generarIncidencias(datosPaginacion);
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
        generarIncidencias(datosPaginacion);
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
        generarIncidencias(datosPaginacion);
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
        generarIncidencias(datosPaginacion);
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
    generarIncidencias(datosPaginacion);
}

//metodo para poder genera el select de subtipos en funcion del tipo seleccionado anteriormente
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

// Funcion para filtrado de atributos estaticos
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

// Función para obtener el nombre completo del creador
function obtenerNombreCompleto(creador)
{
    return `${creador.nombre} ${creador.apellido1} ${creador.apellido2}`;
}

// Funcion para filtrar por usuario
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

// Funcion para filtrar por usuario
function filtroUsuarioTemp(datosFiltrados,nombreInput)
{
    //devuelvo la incidencia si el creador de la misma es el mismo por el que preguntan
    return datosFiltrados.filter
    (item =>
        //obtenerNombreCompleto(item.creador).toLowerCase().includes(nombreInput.toLowerCase())
        item.creador.nombre_completo.toLowerCase().includes(nombreInput.toLowerCase())
    );
}

//funcion para filtrar por fecha
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

//metodo para saber que filtros hay que hacer
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

    //
    if(fechaDesdeFiltro.value=="" && fechaHastaFiltro.value!="")
    {
        //
        alert("la fecha como minimo hay que poner desde cuando hay que buscar");
        return;
    }

    if(idFiltro.value!="")
    {
        criterios.id=parseInt(idFiltro.value);
    }

    if(tipoFiltro.value!="-1")
    {
        criterios.tipo=tipoFiltro.value;
    }

    if(subtipoFiltro.value!="-1")
    {
        let subtipo={subtipo_nombre:subtipoFiltro.value};
        criterios.subtipo=subtipo;
    }

    if(prioridadFiltro.value!="-1")
    {
        criterios.prioridad=prioridadFiltro.value;
    }

    if(estadoFiltro.value!="-1")
    {
        criterios.estado=estadoFiltro.value;
    }

    console.log(criterios);
    filtrados=filtrarObjetos(datosIncidencias,criterios);
    //console.log(filtrados);

    if(nombreFiltro.value!="")
    {
        filtradosNombre=filtroUsuarioTemp(filtrados,nombreFiltro.value);
        //console.log(filtradosNombre);
    }

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

    console.log(datosFinales);

    pagina=0;
    paginaActual.value=1;

    crearArrayPaginacion(datosFinales);

    //metodo generico para mostrar las incidencias
    generarIncidencias(datosPaginacion);
}


function borrarFiltros()
{
    idFiltro.value="";
    nombreFiltro.value="";
    tipoFiltro.value="-1";
    subtipoFiltro.value="-1";
    generarSubtipos();
    prioridadFiltro.value="-1";
    fechaDesdeFiltro.value="";
    fechaHastaFiltro.value="";
    estadoFiltro.value="-1";

    pagina=0;
    paginaActual.value=1;

    crearArrayPaginacion(datosIncidencias);

    //metodo generico para mostrar las incidencias
    generarIncidencias(datosPaginacion);
}

//metodo generico para mostrar las incidencias
function generarIncidencias(datos)
{
    document.querySelector("#contenedorIncidencias").innerHTML="";

    for(let i=0;datos[pagina].length;i++)
    {
        //console.log(item.id);
        let stringRedirect="http://127.0.0.1:8000/incidencias/"+datos[pagina][i].id;

        let divPadre=document.createElement("div");//contenedor de la incidencia
        divPadre.classList="lista-incidencias";

        let divPadreIntero=document.createElement("div");//div interno a la incidcencia
        divPadreIntero.classList="row d-flex justify-content-between align-items-center flex-nowrap rounded";

        let divId=document.createElement("div");//id
        divId.classList="col p-3 baja-res";
        divId.addEventListener("click",()=>redirect(stringRedirect),false);

        let divUsuario=document.createElement("div");//usuario
        divUsuario.classList="col p-3 baja-res";
        divUsuario.addEventListener("click",()=>redirect(stringRedirect),false);

        let divTipoIncidencia=document.createElement("div");//tipo
        divTipoIncidencia.classList="col p-3 text-ellipsis";
        divTipoIncidencia.addEventListener("click",()=>redirect(stringRedirect),false);

        let divSubtipo=document.createElement("div");//subtipo
        divSubtipo.classList="col p-3 text-ellipsis";
        divSubtipo.addEventListener("click",()=>redirect(stringRedirect),false);

        let divFecha=document.createElement("div");
        divFecha.classList="col p-3 baja-res";
        divFecha.addEventListener("click",()=>redirect(stringRedirect),false);

        let divPrioridad=document.createElement("div");//prioridad
        divPrioridad.classList="col p-3 text-ellipsis";
        divPrioridad.addEventListener("click",()=>redirect(stringRedirect),false);

        let divEstado=document.createElement("div");//estado
        divEstado.classList="col p-3 text-ellipsis";
        divEstado.addEventListener("click",()=>redirect(stringRedirect),false);

        let divBotones=document.createElement("div");//botones
        divBotones.classList="col p-3 movil-res";

        let divBotonesInterno=document.createElement("div");//div interno a los botones
        divBotonesInterno.classList="d-flex flex-column justify-content-center gap-2";

        let formBorrar=document.createElement("form");
        formBorrar.classList="d-flex";
        formBorrar.action="http://127.0.0.1:8000/ruta/"+datos[pagina][i].id;
        formBorrar.id="formulario"+datos[pagina][i].id;
        formBorrar.setAttribute("idincidencia",datos[pagina][i].id);

        let textId=document.createTextNode(datos[pagina][i].id);//id
        let textUsuario=document.createTextNode(datos[pagina][i].creador.nombre_completo);//usuario
        let textTipoIncidencia=document.createTextNode(datos[pagina][i].tipo);//tipo
        let textSubtipo=document.createTextNode(datos[pagina][i].subtipo.subtipo_nombre);//subtipo
        let textFecha=document.createTextNode(datos[pagina][i].fecha_creacion);
        let textPrioridad=document.createTextNode(datos[pagina][i].prioridad);//prioridad
        let textEstado=document.createTextNode(datos[pagina][i].estado);//estado

        let aDetalles=document.createElement("a");
        aDetalles.innerHTML="Detalles";
        aDetalles.type="button";
        aDetalles.href="http://127.0.0.1:8000/incidencias/"+datos[pagina][i].id;
        aDetalles.classList="btn aquamarine-400 text-white";
        let inputBorrar=document.createElement("input");
        inputBorrar.value="Borrar";
        inputBorrar.type="submit";
        inputBorrar.classList="btn aquamarine-400 text-white flex-fill";
        inputBorrar.setAttribute("data-bs-toggle","modal");
        inputBorrar.setAttribute("data-bs-target","#staticBackdrop");
        inputBorrar.addEventListener("click",preguntarBorrado,false);

        formBorrar.appendChild(inputBorrar);
        divBotonesInterno.appendChild(formBorrar);
        divBotonesInterno.appendChild(aDetalles);

        divId.appendChild(textId);
        divUsuario.appendChild(textUsuario);
        divTipoIncidencia.appendChild(textTipoIncidencia);
        divSubtipo.appendChild(textSubtipo);
        divFecha.appendChild(textFecha);
        divPrioridad.appendChild(textPrioridad);
        divEstado.appendChild(textEstado);
        divBotones.appendChild(divBotonesInterno);

        divPadreIntero.appendChild(divId);
        divPadreIntero.appendChild(divUsuario);
        divPadreIntero.appendChild(divTipoIncidencia);
        divPadreIntero.appendChild(divSubtipo);
        divPadreIntero.appendChild(divFecha);
        divPadreIntero.appendChild(divPrioridad);
        divPadreIntero.appendChild(divEstado);
        divPadreIntero.appendChild(divBotones);

        divPadre.appendChild(divPadreIntero);

        document.querySelector("#contenedorIncidencias").appendChild(divPadre);

        //divPadre.addEventListener("click",verEnviarIncidencia,false);

        console.log(pagina);
        if(pagina==0)
        {
            anterior.disabled=true;
            anterior.parentNode.classList="page-item disabled";

            siguiente.disabled=false;
            siguiente.parentNode.classList="page-item";

            finalPaginacion.disabled=false;
            finalPaginacion.parentNode.classList="page-item";

            inicioPaginacion.disabled=true;
            inicioPaginacion.parentNode.classList="page-item disabled";
        }

        if(pagina==datos.length-1)
        {
            siguiente.disabled=true;
            siguiente.parentNode.classList="page-item disabled";

            anterior.disabled=false;
            anterior.parentNode.classList="page-item";

            finalPaginacion.disabled=true;
            finalPaginacion.parentNode.classList="page-item disabled";

            inicioPaginacion.disabled=false;
            inicioPaginacion.parentNode.classList="page-item";
        }

        if(pagina>0 && pagina<datos.length-1)
        {
            siguiente.disabled=false;
            siguiente.parentNode.classList="page-item";

            anterior.disabled=false;
            anterior.parentNode.classList="page-item";

            finalPaginacion.disabled=false;
            finalPaginacion.parentNode.classList="page-item";

            inicioPaginacion.disabled=false;
            inicioPaginacion.parentNode.classList="page-item";
        }

        paginasTotales.innerHTML="/ "
        paginasTotales.innerHTML+=datos.length;
    }
}

function redirect(url)
{
    window.location.href=url;
}

//funcion para parar el evento de borrado
function preguntarBorrado(event)
{
    event.preventDefault();
    numeroID.innerHTML=event.target.parentNode.getAttribute("idincidencia");
    idFormularioBorrado=event.target.parentNode.id;
    //console.log(event.target.parentNode);
}

// funcion para realizar la confirmacion del borrado del registro
function confiramarBorrado()
{
    //console.log(idFormularioBorrado);
    let formulario=document.querySelector("#"+idFormularioBorrado);
    formulario.submit();
}
