document.addEventListener("DOMContentLoaded", function () {
    const filtroCategoria = document.getElementById("filtro-categoria");
    const filtroUnidad = document.getElementById("filtro-unidad");
    const buscarProducto = document.getElementById("buscarProducto");

    function filtrar() {
        const categoria = filtroCategoria.value;
        const unidad = filtroUnidad.value;
        const filtroTexto = buscarProducto.value.toLowerCase();

        const filas = document.querySelectorAll("#container-productos-table tr");

        filas.forEach((fila) => {
            const celdaNombre = fila.querySelector("td:nth-child(2)");
            const celdaCategoria = fila.querySelector("td[data-id-categoria]");
            const celdaUnidad = fila.querySelector("td[data-id-unidad]");

            const idCategoria = celdaCategoria?.dataset.idCategoria || "";
            const idUnidad = celdaUnidad?.dataset.idUnidad || "";
            const nombreProducto = celdaNombre ? celdaNombre.textContent.toLowerCase() : "";

            const coincideCategoria = categoria === "" || idCategoria === categoria;
            const coincideUnidad = unidad === "" || idUnidad === unidad;
            const coincideNombre = filtroTexto === "" || nombreProducto.includes(filtroTexto);

            fila.style.display = (coincideCategoria && coincideUnidad && coincideNombre) ? "" : "none";
        });
    }

    filtroCategoria.addEventListener("change", filtrar);
    filtroUnidad.addEventListener("change", filtrar);
    buscarProducto.addEventListener("input", filtrar);
    // Inicializar el filtro al cargar la página
});
