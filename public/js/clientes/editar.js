const btnOcultarModalEdit = document.querySelector(
    "#ocultar-modal-editar-clientes"
);
const contModalEdit = document.querySelector(
    "#container-modal-editar-clientes"
);
function resetValidacionesEdit() {
    document
        .querySelectorAll("#form_editar-clientes .form-group__cliente")
        .forEach((grupo) => {
            grupo.classList.remove(
                "form-group__cliente__correcto",
                "form-group__cliente__incorrecto"
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
    const btn = e.target.closest("#btn-editar-cliente");
    if (!btn) return;

    e.preventDefault();
    const id_cliente = btn.dataset.id_cliente;
    console.log("Botón editar clickeado, ID:", id_cliente);

    fetch(`/admin/clientes/${id_cliente}`)
        .then((response) => response.json())
        .then((data) => {
            console.log("datos recibidos", data);
            document.getElementById("nombre_cliente-editar").value =
                data.nombre_cliente;
            document.getElementById("apellido_cliente-editar").value =
                data.apellido_cliente;
            document.getElementById("documento_cliente-editar").value =
                data.documento_cliente;
            document.getElementById("telefono_cliente-editar").value =
                data.telefono_cliente;
            document.getElementById("direccion_cliente-editar").value =
                data.direccion_cliente;
            document.getElementById("correo_cliente-editar").value =
                data.correo_cliente;

            document.getElementById(
                "form_editar-clientes"
            ).action = `/admin/clientes/${id_cliente}`;
            contModalEdit.classList.add("mostrar");
        })
        .catch((error) => console.error("Error al cargar datos:", error));
});
