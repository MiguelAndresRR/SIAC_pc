document.addEventListener("click", function (e) {
    const btn = e.target.closest(".borrar-boton");
    if (!btn) return;

    const id_compra = btn.dataset.id_compra;
    const id_detalle_compra = btn.dataset.id_detalle_compra;

    const formId = "formEliminar" + id_compra + "_" + id_detalle_compra;
    const form = document.getElementById(formId);

    if (!form) {
        console.error("Formulario no encontrado:", formId);
        return;
    }

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
            form.submit();
        }
    });
});
