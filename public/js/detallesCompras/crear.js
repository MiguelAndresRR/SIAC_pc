//despliega el modal para crear los detalles de la compra
function asignarEventosModalCrear() {
    const btnAbrirModal = document.querySelector("#crear-modal-detallesCompras");
    const btnCerrarModal = document.querySelector("#ocultar-modal-crear-detallesCompras");
    const contModal = document.querySelector(".container-modal-crear-detallesCompras");

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
