//Este script nos permite llamar los datos para ver los detalles que tenga el registro.
document.addEventListener("DOMContentLoaded", function () {
    const btnOcultarModalShow = document.querySelector("#ocultar-modal-usuarios");
    const contModalShow = document.querySelector(".container-modal-show");

    if (btnOcultarModalShow) {
        btnOcultarModalShow.addEventListener("click", (e) => {
            e.preventDefault();
            contModalShow.classList.remove("mostrar");
        });
    }

    function asignarEventosBotones() {
        document.querySelectorAll(".usuarios-btn-ver").forEach((btn) => {
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                const id_usuario = this.dataset.id_usuario;

                console.log("Clic en .btn-ver con ID:", id_usuario);

                fetch(`/admin/usuarios/${id_usuario}`)
                    .then((response) => response.json())
                    .then((data) => {
                        document.getElementById("ver_nombre_usuario").textContent = data.nombre_usuario;
                        document.getElementById("ver_apellido_usuario").textContent = data.apellido_usuario;
                        document.getElementById("ver_documento_usuario").textContent = data.documento_usuario;
                        document.getElementById("ver_correo_usuario").textContent = data.correo_usuario;
                        document.getElementById("ver_telefono_usuario").textContent = data.telefono_usuario;
                        document.getElementById("ver_user_usuario").textContent = data.user;
                        document.getElementById("ver_rol_usuario").textContent = data.nombre_rol;
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
