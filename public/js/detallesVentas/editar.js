const btnOcultarModalEdit = document.querySelector(
    "#ocultar-modal-editar-detallesCompras"
);
const contModalEdit = document.querySelector(
    ".container-modal-editar-detallesCompras"
);

btnOcultarModalEdit.addEventListener("click", (e) => {
    e.preventDefault();
    contModalEdit.classList.remove("mostrar");
});

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-editar");
    if (!btn) return;

    e.preventDefault();
    const id_detalle_compra = btn.dataset.id_detalle_compra;
    const idCompra = btn.dataset.id_compra;
    console.log("Botón editar clickeado, ID:", id_detalle_compra);

    fetch(`/admin/compras/detalles/editar/${id_detalle_compra}`)
        .then((response) => response.json())
        .then((data) => {
            console.log("datos recibidos", data);
            document.querySelector("#id_compra_edit").value = data.id_compra;
            let select = document.querySelector("#productoSelect1").tomselect;
            select.setValue(String(data.id_producto), true);
            document.querySelector("#cantidad").value = data.cantidad_producto;
            document.querySelector("#precio_unitario_edit").value =
                data.precio_unitario;
            document.getElementById(
                "form_editar-detallesCompras"
            ).action = `/admin/detallesCompras/${data.id_detalle_compra}`;
            console.log("Modal mostrado");
            contModalEdit.classList.add("mostrar");
        })
        .catch((error) => console.error("Error al cargar datos:", error));
});
