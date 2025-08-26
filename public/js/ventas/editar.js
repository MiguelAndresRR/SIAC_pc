const btnOcultarModalEdit = document.querySelector(
    "#ocultar-modal-editar-ventas"
);
const contModalEdit = document.querySelector(".container-modal-editar-ventas");

btnOcultarModalEdit.addEventListener("click", (e) => {
    e.preventDefault();
    contModalEdit.classList.remove("mostrar");
});

document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-editar");
    if (!btn) return;

    e.preventDefault();
    const id_venta = btn.dataset.id_venta;
    console.log("Botón editar clickeado, ID:", id_venta);

    fetch(`/admin/ventas/${id_venta}`)
        .then((response) => response.json())
        .then((data) => {
            console.log("datos recibidos", data);
            let select = document.querySelector("#id_cliente-editar").tomselect;
            select.setValue(String(data.id_cliente), true);
            document.getElementById("user").value = data.usuario;
            document.getElementById("fecha_venta").value = data.fecha_venta;
            document.getElementById(
                "form_editar-ventas"
            ).action = `/admin/ventas/${id_venta}`;
            console.log("Modal mostrado");
            contModalEdit.classList.add("mostrar");
        })
        .catch((error) => console.error("Error al cargar datos:", error));
});
