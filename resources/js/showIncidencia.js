/**
 * Event listener que se ejecuta cuando la página se carga por completo.
 * Llama a la función 'inicio'.
 *
 * @event load
 * @type {EventListener}
 */
addEventListener("load",inicio,false);

/**
 * Función de inicialización que configura eventos, como el clic en el botón de borrar, al cargar la página.
 *
 * @function
 * @name inicio
 * @returns {void}
 */
function inicio()
{
    console.log("furula");
    botonBorrar.addEventListener("click",preguntarBorrado,false);
    activarBorrado.addEventListener("click",confirmarBorrado,false);
}

/**
 * Prevención del comportamiento predeterminado del evento.
 *
 * @function
 * @name preguntarBorrado
 * @param {Event} event - Objeto de evento que desencadena la función.
 * @returns {void}
 */
function preguntarBorrado(event)
{
    event.preventDefault();
}

/**
 * Envía el formulario de borrado después de la confirmación.
 *
 * @function
 * @name confirmarBorrado
 * @returns {void}
 */
function confirmarBorrado()
{
    formBorrar.submit()
}
