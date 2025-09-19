//Se activa cuando el usuario quiere borrar el registro, cuando se confirme
//se enviara al controlador para que este registro sea borrado.
document.addEventListener("click", function (e) {
    const btn = e.target.closest(".borrar-boton");
    if (!btn) return;

    const id_venta = btn.dataset.id_venta;

    Swal.fire({
        title: "¿Estás seguro?",
        text: "¡No podrás revertir esto!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
        customClass: {
            confirmButton: "btn-confirmar",
            cancelButton: "btn-cancelar",
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("formEliminar" + id_venta).submit();
        }
    });
});
