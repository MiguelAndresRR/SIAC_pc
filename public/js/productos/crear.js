//Esta funcion nos permite mostrar el modal para crear el resgistro y tambien de cerrarlo
function asignarEventosModalCrear() {
    const btnAbrirModal = document.querySelector("#crear-modal-productos");
    const btnCerrarModal = document.querySelector("#ocultar-modal-crear-productos");
    const contModal = document.querySelector(".container-modal-crear-productos");

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
            resetValidaciones();
            contModal.classList.remove("mostrar");
            console.log("✅ Modal cerrado");
        });
    }
}
//Esta funcion nos permite que al cerrar el
//modal dejen de mostrarse las validaciones del formulario
function resetValidaciones() {
    document
        .querySelectorAll("#FormularioProductosCrear .form-group__producto")
        .forEach((grupo) => {
            grupo.classList.remove(
                "form-group__producto__correcto",
                "form-group__producto__incorrecto"
            );
        });
}
// Al cargar la página
asignarEventosModalCrear();
window.asignarEventosModalCrear = asignarEventosModalCrear;
