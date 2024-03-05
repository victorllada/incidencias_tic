addEventListener("load", inicio, false);

function inicio() {
    document.querySelectorAll('.export-link').forEach(element => {
        element.addEventListener('click', () => {

            // Muestra el loader al hacer clic en cualquier enlace de exportación
            let loader = document.querySelector(".loader");
            loader.style.display = "flex";
            var temp = setTimeout(() => {
                loader.style.display = 'none';
            }, 4000);
        });
    });
}
