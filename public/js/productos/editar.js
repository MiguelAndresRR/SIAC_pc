const btnOcultarModalEdit = document.querySelector("#ocultar-modal-editar-productos");
const contModalEdit = document.querySelector(".container-modal-editar-productos");

btnOcultarModalEdit.addEventListener("click", (e) => {
    e.preventDefault();
    resetValidacionesEdit();
    contModalEdit.classList.remove("mostrar");
});
function resetValidacionesEdit() {
    document
        .querySelectorAll("#form_editar .form-group__producto")
        .forEach((grupo) => {
            grupo.classList.remove(
                "form-group__producto__correcto",
                "form-group__producto__incorrecto"
            );
        });
}
document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-editar");
    if (!btn) return;

    e.preventDefault();
    const id_producto = btn.dataset.id_producto;

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
            document.getElementById("form_editar").action = `/admin/productos/${id_producto}`;
            contModalEdit.classList.add("mostrar");
        })
        .catch((error) => console.error("Error al cargar datos:", error));
});