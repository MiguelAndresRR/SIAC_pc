//Este script nos permite llamar los datos para ver los detalles que tenga el registro.
document.addEventListener("DOMContentLoaded", function () {
    const btnOcultarModalShow = document.querySelector("#ocultar-modal-proveedores");
    const contModalShow = document.querySelector(".container-modal-show-proveedores");

    if (btnOcultarModalShow) {
        btnOcultarModalShow.addEventListener("click", (e) => {
            e.preventDefault();
            contModalShow.classList.remove("mostrar");
        });
    }

    function asignarEventosBotones() {
        document.querySelectorAll(".btn-ver").forEach((btn) => {
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                const id_proveedor = this.dataset.id_proveedor;

                console.log("Clic en .btn-ver con ID:", id_proveedor);

                fetch(`/admin/proveedores/${id_proveedor}`)
                    .then((response) => response.json())
                    .then((data) => {
                        document.getElementById("ver_nombre_proveedor").textContent = data.nombre_proveedor;
                        document.getElementById("ver_nit_proveedor").textContent = data.nit_proveedor;
                        document.getElementById("ver_direccion_proveedor").textContent = data.direccion_proveedor;
                        document.getElementById("ver_telefono_proveedor").textContent = data.telefono_proveedor;
                        document.getElementById("ver_correo_proveedor").textContent = data.correo_proveedor;
                        contModalShow.classList.add("mostrar");
                    })
                    .catch((error) => console.error("Error al cargar datos:", error));
            });
        });
    }

    // Asignar al cargar por primera vez
    asignarEventosBotones();

    // Exponer globalmente para que el otro script lo llame
    window.asignarEventosBotones = asignarEventosBotones;
});
