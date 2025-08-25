document.addEventListener("click", function (e) {
    const btn = e.target.closest(".borrar-boton");
    if (!btn) return;

    const id_cliente = btn.dataset.id_cliente;

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
            document.getElementById("formEliminar" + id_cliente).submit();
        }
    });
});
