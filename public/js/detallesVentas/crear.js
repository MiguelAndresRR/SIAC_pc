function asignarEventosModalCrear() {
    const btnAbrirModal = document.querySelector("#crear-modal-detallesVentas");
    const btnCerrarModal = document.querySelector("#ocultar-modal-crear-detallesVentas");
    const contModal = document.querySelector(".container-modal-crear-detallesVentas");

    if (btnAbrirModal) {
        btnAbrirModal.addEventListener("click", (e) => {
            e.preventDefault();
            contModal.classList.add("mostrar");
        });
    }

    if (btnCerrarModal) {
        btnCerrarModal.addEventListener("click", (e) => {
            e.preventDefault();
            contModal.classList.remove("mostrar");
        });
    }

    
}
// Al cargar la página
asignarEventosModalCrear();
window.asignarEventosModalCrear = asignarEventosModalCrear;
