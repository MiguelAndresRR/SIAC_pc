const btnLanzarModal = document.querySelector("#crear-modal");
const btnOcultarModal = document.querySelector("#ocultar-modal-crear");
const contModalCrear = document.querySelector(".container-modal-crear");

btnLanzarModal.addEventListener("click", (e) => {
    e.preventDefault();
    contModalCrear.classList.add("mostrar");
});
btnOcultarModal.addEventListener("click", (e) => {
    e.preventDefault();
    contModalCrear.classList.remove("mostrar");
});
