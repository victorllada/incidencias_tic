addEventListener("load",inicio,false);

function inicio()
{
    console.log("furula");
    botonBorrar.addEventListener("click",preguntarBorrado,false);
    activarBorrado.addEventListener("click",confirmarBorrado,false);
}

function preguntarBorrado(event)
{
    event.preventDefault();
}

function confirmarBorrado()
{
    formBorrar.submit()
}
