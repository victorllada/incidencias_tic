document.addEventListener("DOMContentLoaded", () => {
    const exportLinks = document.querySelectorAll('.export-link');

    // Agrega un evento de clic a todos los elementos con la clase 'export-link'
    exportLinks.forEach(link => {
        link.addEventListener('click', () => {
            // Muestra el loader al hacer clic en cualquier enlace de exportación
            const loader = document.getElementById("loader");
            loader.style.display = "block";
            setTimeout(() => {
                loader.style.opacity = "0";
                loader.style.transition = "opacity 1.2s ease-in-out";
            }, 500);
            setTimeout(() => {
                loader.remove();
            }, 1700);
        });
    });
});
