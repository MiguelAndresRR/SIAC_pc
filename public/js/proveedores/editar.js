const btnOcultarModalEdit = document.querySelector("#ocultar-modal-editar-proveedores");
const contModalEdit = document.querySelector(".container-modal-editar-proveedores");
function resetValidacionesEdit() {
    document
        .querySelectorAll("#FormularioProveedorEditar .form-group__proveedor")
        .forEach((grupo) => {
            grupo.classList.remove(
                "form-group__proveedor__correcto",
                "form-group__proveedor__incorrecto"
            );
        });
}
if (btnOcultarModalEdit) {
    btnOcultarModalEdit.addEventListener("click", (e) => {
        e.preventDefault();
        resetValidacionesEdit();
        contModalEdit.classList.remove("mostrar");
    });
}


document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-editar");
    if (!btn) return;

    e.preventDefault();
    const id_proveedor = btn.dataset.id_proveedor;

    fetch(`/admin/proveedores/${id_proveedor}`)
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("nombre_proveedor").value =
                data.nombre_proveedor;
            document.getElementById("nit_proveedor").value =
                data.nit_proveedor;
            document.getElementById("direccion_proveedor").value =
                data.direccion_proveedor;
            document.getElementById("telefono_proveedor").value =
                data.telefono_proveedor;
            document.getElementById("correo_proveedor").value =
                data.correo_proveedor;
            document.getElementById("FormularioProveedorEditar").action = `/admin/proveedores/${id_proveedor}`;
            console.log("Modal mostrado");
            contModalEdit.classList.add("mostrar");
        })
        .catch((error) => console.error("Error al cargar datos:", error));
});