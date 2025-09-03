document.querySelectorAll(".borrar-boton").forEach((btn) => {
    btn.addEventListener("click", function () {
        const id_producto = this.dataset.id_producto;
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
            buttonsStyling: false // 🔥 importante para que tus clases tomen efecto
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("formEliminar" + id_producto).submit();
            }
        });
    });
});
