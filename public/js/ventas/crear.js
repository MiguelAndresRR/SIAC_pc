function asignarEventosModalCrear() {
    const btnAbrirModal = document.querySelector("#crear-modal-compras");
    const btnCerrarModal = document.querySelector("#ocultar-modal-crear-compras");
    const contModal = document.querySelector(".container-modal-crear-compras");

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
