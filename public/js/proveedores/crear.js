function asignarEventosModalCrear() {
    const btnAbrirModal = document.querySelector("#crear-modal-proveedores");
    const btnCerrarModal = document.querySelector("#ocultar-modal-crear-proveedores");
    const contModal = document.querySelector(".container-modal-crear-proveedores");

    if (btnAbrirModal) {
        btnAbrirModal.addEventListener("click", (e) => {
            e.preventDefault();
            contModal.classList.add("mostrar");
        });
    }

    if (btnCerrarModal) {
        btnCerrarModal.addEventListener("click", (e) => {
            e.preventDefault();
            resetValidaciones();
            contModal.classList.remove("mostrar");
        });
    }
}
function resetValidaciones() {
    document
        .querySelectorAll("#formularioProveedor .form-group__proveedor")
        .forEach((grupo) => {
            grupo.classList.remove(
                "form-group__proveedor__correcto",
                "form-group__proveedor__incorrecto"
            );
        });
}

// Al cargar la página
asignarEventosModalCrear();
window.asignarEventosModalCrear = asignarEventosModalCrear;
