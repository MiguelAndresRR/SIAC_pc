document.addEventListener("DOMContentLoaded", function () {
    const buscarProducto = document.getElementById("buscarProducto");

    buscarProducto.addEventListener("input", function () {
        const filtro = buscarProducto.value.toLowerCase();
        const filas = document.querySelectorAll("#container-productos-table tr");

        filas.forEach((fila) => {
            const celdaNombre = fila.querySelector("td:nth-child(2)");

            if (celdaNombre) {
                const texto = celdaNombre.textContent.toLowerCase();
                const coincide = texto.includes(filtro);
                fila.style.display = coincide ? "" : "none";
            }
        });
    });
});

