document.addEventListener("DOMContentLoaded", function () {
    const btnOcultarModalShow = document.querySelector("#ocultar-modal-show-detallesCompras");
    const contModalShow = document.querySelector(".container-modal-show-detallesCompras");

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

                fetch(`/admin/proveedor/${id_proveedor}`)
                    .then((response) => response.json())
                    .then((data) => {
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
