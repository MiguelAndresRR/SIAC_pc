const btnOcultarModalEdit = document.querySelector(
    "#ocultar-modal-editar-detallesVentas"
);
const contModalEdit = document.querySelector(
    ".container-modal-editar-detallesVentas"
);

btnOcultarModalEdit.addEventListener("click", (e) => {
    e.preventDefault();
    contModalEdit.classList.remove("mostrar");
});

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-agregar");
    if (!btn) return;

    e.preventDefault();
    const id_detalle_venta = btn.dataset.id_detalle_venta;
    const id_venta = btn.dataset.id_venta;
    console.log("Botón editar clickeado, ID:", id_detalle_venta);

    fetch(`/admin/ventas/detalles/editar/${id_detalle_venta}`)
        .then((response) => response.json())
        .then((data) => {
            console.log("datos recibidos", data);
            document.querySelector("#id_venta_edit").value = data.id_venta;
            let select = document.querySelector(
                "#productoSelectEditar"
            ).tomselect;
            select.setValue(String(data.id_producto), true);
            document.querySelector("#cantidad_venta").value =
                data.cantidad_venta;
            document.querySelector("#precio_unitario_venta-edit").value =
                data.precio_unitario_venta;
            console.log(
                "Precio unitario recibido:",
                data.precio_unitario_venta
            );
            document.getElementById(
                "form_editar-detallesVentas"
            ).action = `/admin/detallesVentas/${data.id_detalle_venta}`;
            console.log("Modal mostrado");
            contModalEdit.classList.add("mostrar");
        })
        .catch((error) => console.error("Error al cargar datos:", error));
});
