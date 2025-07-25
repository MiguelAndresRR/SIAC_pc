function asignarEventosModalCrear() {
    const btnAbrirModal = document.querySelector("#crear-modal-proveedor");
    const btnCerrarModal = document.querySelector("#ocultar-modal-crear-proveedor");
    const contModal = document.querySelector(".container-modal-crear-proveedor");

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
