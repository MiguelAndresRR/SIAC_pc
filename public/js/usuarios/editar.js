const btnOcultarModalEdit = document.querySelector("#ocultar-modal-editar2");
const contModalEdit = document.querySelector("#container-modal-editar2");

function resetValidacionesEdit() {
    document
        .querySelectorAll("#form_editar1 .form-group__usuario")
        .forEach((grupo) => {
            grupo.classList.remove(
                "form-group__usuario__correcto",
                "form-group__usuario__incorrecto"
            );
        });
}

if (btnOcultarModalEdit) {
    btnOcultarModalEdit.addEventListener("click", (e) => {
        e.preventDefault();
        resetValidacionesEdit()
        contModalEdit.classList.remove("mostrar");
    });
}

document.addEventListener("click", function (e) {
    const btn = e.target.closest("#btn-editar1");
    if (!btn) return;

    e.preventDefault();
    const id_usuario = btn.dataset.id_usuario;
    console.log("Botón editar clickeado, ID:", id_usuario);

    fetch(`/admin/usuarios/index/${id_usuario}`)
        .then((response) => response.json())
        .then((data) => {
            console.log("datos recibidos", data);
            document.getElementById("nombre_usuario-editar").value =
                data.nombre_usuario;
            document.getElementById("apellido_usuario-editar").value =
                data.apellido_usuario;
            document.getElementById("documento_usuario-editar").value =
                data.documento_usuario;
            document.getElementById("telefono_usuario-editar").value =
                data.telefono_usuario;
            document.getElementById("correo_usuario-editar").value =
                data.correo_usuario;
            document.getElementById("user-editar").value = data.user;
            document.getElementById("id_rol-editar").value = data.id_rol;

            document.getElementById(
                "form_editar1"
            ).action = `/admin/usuarios/${id_usuario}`;
            contModalEdit.classList.add("mostrar");
        })
        .catch((error) => console.error("Error al cargar datos:", error));
});
