document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("filtro-form-detallesCompras");
    console.log("Form encontrado:", form);

    if (!form) {
        console.error("No se encontró el formulario filtro-form-detallesCompras");
        return;
    }

    function filtro() {
        console.log("Ejecutando filtro...");
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();
        const idCompra = form.dataset.id_compra_detalles;
        fetch(`/admin/compras/${idCompra}/detalles/?${params}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((res) => res.text())
            .then((html) => {
                document.getElementById("tabla-detallesCompras").innerHTML = html;

                if (typeof window.asignarEventosBotones === "function") {
                    console.log("Reasignando eventos a .btn-agregar");
                    window.asignarEventosBotones();
                } else {
                    console.log("No se encontró window.asignarEventosBotones");
                }
                if (typeof window.asignarEventosModalCrear === "function") {
                    console.log("Reasignando eventos a .btn-crear");
                    window.asignarEventosModalCrear();
                } else {
                    console.log(
                        "No se encontró window.asignarEventosModalCrear"
                    );
                }
            })
            .catch((error) => {
                console.error("Error en filtro:", error);
            });
    }

    form.addEventListener("change", filtro);

    const limpiarBtn = document.getElementById("limpiar-filtros-detallesCompras");

    console.log("Limpiar botón encontrado:", limpiarBtn);

    if (limpiarBtn) {
        console.log("Agregando evento click al botón limpiar");
        limpiarBtn.addEventListener("click", function (e) {
            console.log("Botón limpiar clickeado");
            e.preventDefault();
            e.stopPropagation();
            form.reset();
            filtro();
        });
    } else {
        console.error("No se encontró el botón limpiar-filtros-detallesCompras");
    }


    document.addEventListener("click", function (e) {
        if (e.target.matches(".pagination a")) {
            e.preventDefault();

            const url = new URL(e.target.href);
            const formData = new FormData(form);
            formData.forEach((value, key) => {
                url.searchParams.set(key, value);
            });

            fetch(url.toString(), {
                headers: { "X-Requested-With": "XMLHttpRequest" },
            })
                .then((res) => res.text())
                .then((html) => {
                    document.getElementById("tabla-detallesCompras").innerHTML = html;
                    if (typeof window.asignarEventosBotones === "function") {
                        window.asignarEventosBotones();
                    }
                });
        }
    });
});
