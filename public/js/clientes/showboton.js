//Este script nos permite llamar los datos para ver los detalles que tenga el registro.
document.addEventListener("DOMContentLoaded", function () {
    const btnOcultarModalShow = document.querySelector(
        "#ocultar-modal-clientes"
    );
    const contModalShow = document.querySelector(".container-modal-show-clientes");

    if (btnOcultarModalShow) {
        btnOcultarModalShow.addEventListener("click", (e) => {
            e.preventDefault();
            contModalShow.classList.remove("mostrar");
        });
    }

    function asignarEventosBotones() {
        document.querySelectorAll(".clientes-btn-ver").forEach((btn) => {
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                const id_cliente = this.dataset.id_cliente;

                console.log("Clic en .btn-ver con ID:", id_cliente);

                fetch(`/admin/clientes/${id_cliente}`)
                    .then((response) => response.json())
                    .then((data) => {
                        document.getElementById(
                            "ver_nombre_cliente"
                        ).textContent = data.nombre_cliente;
                        document.getElementById(
                            "ver_apellido_cliente"
                        ).textContent = data.apellido_cliente;
                        document.getElementById(
                            "ver_documento_cliente"
                        ).textContent = data.documento_cliente;
                        document.getElementById(
                            "ver_telefono_cliente"
                        ).textContent = data.telefono_cliente;
                        document.getElementById(
                            "ver_direccion_cliente"
                        ).textContent = data.direccion_cliente;
                        document.getElementById(
                            "ver_correo_cliente"
                        ).textContent = data.correo_cliente;
                        contModalShow.classList.add("mostrar");
                    })
                    .catch((error) =>
                        console.error("Error al cargar datos:", error)
                    );
            });
        });
    }

    // Asignar al cargar por primera vez
    asignarEventosBotones();

    // Exponer globalmente para que el otro script lo llame
    window.asignarEventosBotones = asignarEventosBotones;
});
