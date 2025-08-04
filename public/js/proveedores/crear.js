function asignarEventosModalCrear() {
    const btnAbrirModal = document.querySelector("#crear-modal-proveedores");
    const btnCerrarModal = document.querySelector("#ocultar-modal-crear-proveedores");
    const contModal = document.querySelector(".container-modal-crear-proveedores");

    if (btnAbrirModal) {
        btnAbrirModal.addEventListener("click", (e) => {
            e.preventDefault();
            contModal.classList.add("mostrar");
            console.log("✅ Modal abierto");
        });
    }

    if (btnCerrarModal) {
        btnCerrarModal.addEventListener("click", (e) => {
            e.preventDefault();
            contModal.classList.remove("mostrar");
            console.log("✅ Modal cerrado");
        });
    }
}

// Al cargar la página
asignarEventosModalCrear();
window.asignarEventosModalCrear = asignarEventosModalCrear;
