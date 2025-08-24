const btnOcultarModalEdit = document.querySelector("#ocultar-modal-editar-compras");
const contModalEdit = document.querySelector(".container-modal-editar-compras");

btnOcultarModalEdit.addEventListener("click", (e) => {
    e.preventDefault();
    contModalEdit.classList.remove("mostrar");
});

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-editar");
    if (!btn) return;

    e.preventDefault();
    const id_compra = btn.dataset.id_compra;
    console.log("Botón editar clickeado, ID:", id_compra);

    fetch(`/admin/compras/${id_compra}`)
        .then((response) => response.json())
        .then((data) => {
            console.log('datos recibidos', data)
            document.getElementById("id_usuario").value = data.id_usuario;
            document.getElementById("user").value = data.usuario;
            document.getElementById("fecha_compra").value = data.fecha_compra;
            document.getElementById("id_proveedor").value = data.id_proveedor;
            document.getElementById("form_editar-compras").action = `/admin/compras/${id_compra}`;
            console.log("Modal mostrado");
            contModalEdit.classList.add("mostrar");
        })
        .catch((error) => console.error("Error al cargar datos:", error));
});