const btnOcultarModalEdit = document.querySelector("#ocultar-modal");
const contModalEdit = document.querySelector(".container-modal-editar");

btnOcultarModalEdit.addEventListener("click", (e) => {
    e.preventDefault();
    contModalEdit.classList.remove("mostrar");
});

document.querySelectorAll(".btn-editar").forEach((btn) => {
    btn.addEventListener("click", function (e) {
        e.preventDefault();
        const id_producto = this.dataset.id_producto;

        fetch(`/admin/productos/${id_producto}`)
            .then((response) => response.json())
            .then((data) => {
                document.getElementById("nombre_producto").value =
                    data.nombre_producto;
                document.getElementById("precio_producto").value =
                    data.precio_producto;
                document.getElementById("id_categoria_producto").value =
                    data.id_categoria_producto;
                document.getElementById("id_unidad_peso_producto").value =
                    data.id_unidad_peso_producto;
                document.getElementById("form_editar").action =
                    `/admin/productos/${id_producto}`;
                contModalEdit.classList.add("mostrar");
            })
            .catch((error) => console.error("Error al cargar datos:", error));
    });
});
