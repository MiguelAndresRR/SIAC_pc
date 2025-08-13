const btnOcultarModalEdit = document.querySelector("#ocultar-modal-editar-detallesCompras");
const contModalEdit = document.querySelector(".container-modal-editar-detallesCompras");

btnOcultarModalEdit.addEventListener("click", (e) => {
    e.preventDefault();
    contModalEdit.classList.remove("mostrar");
});

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-editar");
    if (!btn) return;

    e.preventDefault();
    const id_detalle_compra = btn.dataset.id_detalle_compra;
    console.log("Botón editar clickeado, ID:", id_detalle_compra);

    fetch(`/admin/detallesCompras/${id_detalle_compra}`)
        .then((response) => response.json())
        .then((data) => {
            console.log('datos recibidos', data)
            document.getElementById("form_editar-compras").action = `/admin/detallesCompras/${id_detalle_compra}`;
            console.log("Modal mostrado");
            contModalEdit.classList.add("mostrar");
        })
        .catch((error) => console.error("Error al cargar datos:", error));
});