const btnOcultarModalShow = document.querySelector("#ocultar-modal1");
const contModalShow = document.querySelector(".container-modal-show");

btnOcultarModalShow.addEventListener("click", (e) => {
    e.preventDefault();
    contModalShow.classList.remove("mostrar");
});

document.querySelectorAll(".btn-ver").forEach((btn) => {
    btn.addEventListener("click", function (e) {
        e.preventDefault();
        const id_producto = this.dataset.id_producto;

        fetch(`/admin/productos/${id_producto}`)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById("ver_nombre_producto").textContent =
                    data.nombre_producto;
                document.getElementById(
                    "ver_precio_producto"
                ).textContent = `$${data.precio_producto}`;
                document.getElementById("ver_categoria_producto").textContent =
                    data.categoria;
                document.getElementById(
                    "ver_unidad_peso_producto"
                ).textContent = data.unidad;
                contModalShow.classList.add("mostrar");
            })
            .catch((error) => console.error("Error al cargar datos:", error));
    });
});
