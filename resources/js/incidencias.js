addEventListener("load",inicio,false);

let datosIncidencias;

function inicio()
{
    //llamada de ajax y creacion de las incidencias en el html
    obtenerIncidencias().then(data => {
        datosIncidencias = data; // Guardamos los datos en la variable
        console.log(datosIncidencias); // Ahora deberías poder ver los datos
    });

    filtrar.addEventListener("click",aplicacionFiltros,false);
    borrar.addEventListener("click",borrarFiltros,false);
    tipoFiltro.addEventListener("change",generarSubtipos,false);
}

async function obtenerIncidencias()
{
    try
    {
        let response = await fetch("http://127.0.0.1:8000/datos");
        //console.log(response);
        // Comprueba si la respuesta es exitosa
        if(!response.ok)
        {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        let data = await response.json();

        return data;
    }
    catch (error)
    {
        console.error('Ha ocurrido un error:', error);
    }
}

function generarSubtipos()
{
    subtipoFiltro.innerHTML="<option selected value='-1'>Selecciona el subtipo</option>";
    let array=[];

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

    for (let i=0;i<array.length;i++)
    {
        var opt=document.createElement("option");
        opt.textContent=array[i];
        opt.value=array[i];
        subtipoFiltro.appendChild(opt);
    }
}

function filtrarObjetos(objetos, criterios)
{
    //lo mismo que lo anterior pero tambien con subtipo
    return objetos.filter(objeto =>
        {
            for (let propiedad in criterios)
            {
                if (criterios[propiedad] === undefined)
                {
                    continue;
                }

                // Se agrega la comparación para el subtipo
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
    return objetosFiltrados.filter(objeto =>
        {
            let creador = objeto.creador;
            return(
                creador.nombre.toLowerCase().includes(nombre.toLowerCase()) &&
                creador.apellido1.toLowerCase().includes(apellido1.toLowerCase()) &&
                creador.apellido2.toLowerCase().includes(apellido2.toLowerCase())
            );
        }
    );
}

function filtroUsuarioTemp(datosFiltrados,nombreInput)
{
    return datosFiltrados.filter
    (item =>
        //obtenerNombreCompleto(item.creador).toLowerCase().includes(nombreInput.toLowerCase())
        item.creador.nombre_completo.toLowerCase().includes(nombreInput.toLowerCase())
    );
}

function filtroFecha(datos,fechaDesde,fechaHasta="")
{
    //let datosFiltradosFecha=[];

    if(fechaHasta=="")
    {
        let fechaBusqueda = new Date(fechaDesde);

        return datos.filter(item =>
            {
                let fechaItem = new Date(item.fecha_creacion);

                return (fechaBusqueda.getDate()===fechaItem.getDate() && fechaBusqueda.getMonth()===fechaItem.getMonth() && fechaBusqueda.getFullYear()===fechaItem.getFullYear());
            }
        );
    }
    else
    {
        let fechaBusquedaDesde=new Date(fechaDesde);
        let fechaBusquedaHasta=new Date(fechaHasta);

        return datos.filter(item =>
            {
                let fechaItem = new Date(item.fecha_creacion);

                return (
                    fechaBusquedaDesde.getFullYear()<=fechaItem.getFullYear() && fechaBusquedaHasta.getFullYear()>=fechaItem.getFullYear() &&
                    (fechaBusquedaDesde.getFullYear()<fechaItem.getFullYear() || (fechaBusquedaDesde.getFullYear()===fechaItem.getFullYear() && fechaBusquedaDesde.getMonth()<=fechaItem.getMonth())) &&
                    (fechaBusquedaDesde.getFullYear()<fechaItem.getFullYear() || (fechaBusquedaDesde.getFullYear()===fechaItem.getFullYear() && fechaBusquedaDesde.getMonth()===fechaItem.getMonth() && fechaBusquedaDesde.getDate()<=fechaItem.getDate()))
                );
            }
        );


    }
    //return datosFiltradosFecha;
}

function aplicacionFiltros()
{
/*const objetoEjemplo = {
    actuaciones: "Iste animi ullam aut voluptas id laborum eaque.",
    adjunto_url: "http://www.granados.com/",
    comentarios: [
      {
        // Propiedades del comentario
      },
    ],
    creador: {
      activo: 1,
      apellido1: "Barela",
      apellido2: "Romo",
      cp: "43833",
      created_at: "2024-02-22T20:31:05.000000Z",
      departamento_id: 3,
      direccion: "Calle Diana, 715, 44º D, 41707, Tejada de Ulla",
      dni: "707504887",
      id: 23,
      localidad: "Expedita dicta et fuga.",
      nombre: "Asier",
      tlf: "615174449",
      updated_at: "2024-02-22T20:31:05.000000Z",
    },
    creador_id: 23,
    created_at: "2024-02-22T20:31:05.000000Z",
    descripcion: "Veritatis ut ut distinctio neque non quaerat quisquam.",
    duracion: 247,
    equipo: null,
    equipo_id: null,
    estado: "resuelta",
    fecha_cierre: "2014-06-19 14:54:37",
    fecha_creacion: "2004-12-15 06:18:40",
    id: 2,
    prioridad: "urgente",
    responsable: null,
    responsable_id: null,
    subtipo: {
      created_at: "2024-02-22T20:31:04.000000Z",
      id: 10,
      sub_subtipo: "accusamus",
      subtipo_nombre: "recusandae",
      tipo: "SOFTWARE",
      updated_at: "2024-02-22T20:31:04.000000Z",
    },
    subtipo_id: 10,
    tipo: "CUENTAS",
    updated_at: "2024-02-22T20:31:05.000000Z",
  };*/

    //idFiltro
    //nombreFiltro
    //tipoFiltro
    //subtipoFiltro
    //descripcionFiltro
    //prioridadFiltro
    //fechaDesdeFiltro
    //fechaHastaFiltro
    //estadoFiltro
    console.log(idFiltro.value);
    console.log(nombreFiltro.value);
    console.log(tipoFiltro.value);
    console.log(subtipoFiltro.value);
    console.log(descripcionFiltro.value);
    console.log(prioridadFiltro.value);
    console.log(fechaDesdeFiltro.value);
    console.log(fechaHastaFiltro.value);
    console.log(estadoFiltro.value);

    let criterios={};
    let filtrados=[];
    let filtradosNombre=[];
    let filtradosFecha=[];
    let datosFinales=[];

    if(fechaDesdeFiltro.value=="" && fechaHastaFiltro.value!="")
    {
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

    if(descripcionFiltro.value!="")
    {
        criterios.descripcion=descripcionFiltro.value;
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

    document.querySelector("#contenedorIncidencias").innerHTML="";

    datosFinales.forEach(item =>
        {
            //console.log(item.id);
            let stringRedirect="http://127.0.0.1:8000/incidencias/"+item.id;

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

            let divDesccripcion=document.createElement("div");//dedscripcion
            divDesccripcion.classList="col p-3 text-ellipsis baja-res";
            divDesccripcion.addEventListener("click",()=>redirect(stringRedirect),false);

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

            let textId=document.createTextNode(item.id);//id
            let textUsuario=document.createTextNode(item.creador.nombre_completo);//usuario
            let textTipoIncidencia=document.createTextNode(item.tipo);//tipo
            let textSubtipo=document.createTextNode(item.subtipo.subtipo_nombre);//subtipo
            let textFecha=document.createTextNode(item.fecha_creacion);
            let textDescripcion=document.createTextNode(item.descripcion);//descripcion
            let textPrioridad=document.createTextNode(item.prioridad);//prioridad
            let textEstado=document.createTextNode(item.estado);//estado

            let aDetalles=document.createElement("a");
            aDetalles.innerHTML="Detalles";
            aDetalles.type="button";
            aDetalles.href="http://127.0.0.1:8000/incidencias/"+item.id;
            aDetalles.classList="btn aquamarine-400 text-white";
            let aBorrar=document.createElement("a");
            aBorrar.innerHTML="Borrar";
            aBorrar.type="button";
            aBorrar.href="#";
            aBorrar.classList="btn aquamarine-400 text-white";

            divBotonesInterno.appendChild(aDetalles);
            divBotonesInterno.appendChild(aBorrar);

            divId.appendChild(textId);
            divUsuario.appendChild(textUsuario);
            divTipoIncidencia.appendChild(textTipoIncidencia);
            divSubtipo.appendChild(textSubtipo);
            divFecha.appendChild(textFecha);
            divDesccripcion.appendChild(textDescripcion);
            divPrioridad.appendChild(textPrioridad);
            divEstado.appendChild(textEstado);
            divBotones.appendChild(divBotonesInterno);

            divPadreIntero.appendChild(divId);
            divPadreIntero.appendChild(divUsuario);
            divPadreIntero.appendChild(divTipoIncidencia);
            divPadreIntero.appendChild(divSubtipo);
            divPadreIntero.appendChild(divFecha);
            divPadreIntero.appendChild(divDesccripcion);
            divPadreIntero.appendChild(divPrioridad);
            divPadreIntero.appendChild(divEstado);
            divPadreIntero.appendChild(divBotones);

            divPadre.appendChild(divPadreIntero);

            document.querySelector("#contenedorIncidencias").appendChild(divPadre);

            //divPadre.addEventListener("click",verEnviarIncidencia,false);
        }
    );
}


function borrarFiltros()
{
    idFiltro.value="";
    nombreFiltro.value="";
    tipoFiltro.value="-1";
    subtipoFiltro.value="-1";
    descripcionFiltro.value="";
    prioridadFiltro.value="-1";
    fechaDesdeFiltro.value="";
    fechaHastaFiltro.value="";
    estadoFiltro.value="-1";
    document.querySelector("#contenedorIncidencias").innerHTML="";

    datosIncidencias.forEach(item =>
        {
            //console.log(item.id);
            let stringRedirect="http://127.0.0.1:8000/incidencias/"+item.id;

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

            let divDesccripcion=document.createElement("div");//dedscripcion
            divDesccripcion.classList="col p-3 text-ellipsis baja-res";
            divDesccripcion.addEventListener("click",()=>redirect(stringRedirect),false);

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

            let textId=document.createTextNode(item.id);//id
            let textUsuario=document.createTextNode(item.creador.nombre_completo);//usuario
            let textTipoIncidencia=document.createTextNode(item.tipo);//tipo
            let textSubtipo=document.createTextNode(item.subtipo.subtipo_nombre);//subtipo
            let textFecha=document.createTextNode(item.fecha_creacion);
            let textDescripcion=document.createTextNode(item.descripcion);//descripcion
            let textPrioridad=document.createTextNode(item.prioridad);//prioridad
            let textEstado=document.createTextNode(item.estado);//estado

            let aDetalles=document.createElement("a");
            aDetalles.innerHTML="Detalles";
            aDetalles.type="button";
            aDetalles.href="http://127.0.0.1:8000/incidencias/"+item.id;
            aDetalles.classList="btn aquamarine-400 text-white";
            let aBorrar=document.createElement("a");
            aBorrar.innerHTML="Borrar";
            aBorrar.type="button";
            aBorrar.href="#";
            aBorrar.classList="btn aquamarine-400 text-white";

            divBotonesInterno.appendChild(aDetalles);
            divBotonesInterno.appendChild(aBorrar);

            divId.appendChild(textId);
            divUsuario.appendChild(textUsuario);
            divTipoIncidencia.appendChild(textTipoIncidencia);
            divSubtipo.appendChild(textSubtipo);
            divFecha.appendChild(textFecha);
            divDesccripcion.appendChild(textDescripcion);
            divPrioridad.appendChild(textPrioridad);
            divEstado.appendChild(textEstado);
            divBotones.appendChild(divBotonesInterno);

            divPadreIntero.appendChild(divId);
            divPadreIntero.appendChild(divUsuario);
            divPadreIntero.appendChild(divTipoIncidencia);
            divPadreIntero.appendChild(divSubtipo);
            divPadreIntero.appendChild(divFecha);
            divPadreIntero.appendChild(divDesccripcion);
            divPadreIntero.appendChild(divPrioridad);
            divPadreIntero.appendChild(divEstado);
            divPadreIntero.appendChild(divBotones);

            divPadre.appendChild(divPadreIntero);

            document.querySelector("#contenedorIncidencias").appendChild(divPadre);

            //divPadre.addEventListener("click",verEnviarIncidencia,false);
        }
    );
}

function redirect(url)
{
    window.location.href=url;
}