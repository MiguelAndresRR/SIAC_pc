//Esta funcion nos permite mostrar el modal para crear el resgistro y tambien de cerrarlo
function asignarEventosModalCrear() {
    const btnAbrirModal = document.querySelector("#crear-modal-clientes");
    const btnCerrarModal = document.querySelector("#ocultar-modal-crear-clientes");
    const contModal = document.querySelector(".container-modal-crear-clientes");

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

//Esta funcion nos permite que al cerrar el
//modal dejen de mostrarse las validaciones del formulario
function resetValidaciones() {
    document
        .querySelectorAll("#formularioCliente .form-group__cliente")
        .forEach((grupo) => {
            grupo.classList.remove(
                "form-group__cliente__correcto",
                "form-group__cliente__incorrecto"
            );
        });
}

// Al cargar la página
asignarEventosModalCrear();
window.asignarEventosModalCrear = asignarEventosModalCrear;
