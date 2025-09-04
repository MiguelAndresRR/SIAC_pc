document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("filtro-form-productos");
    console.log("Form encontrado:", form);

    if (!form) {
        console.error("No se encontró el formulario filtro-form-productos");
        return;
    }

    function filtro() {
        console.log("Ejecutando filtro...");
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();

        fetch(`/admin/productos?${params}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((res) => res.text())
            .then((html) => {
                document.getElementById("tabla-productos").innerHTML = html;

                if (typeof window.asignarEventosBotones === "function") {
                    console.log("Reasignando eventos a .btn-ver");
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

    const nombreInput = document.getElementById("buscarProducto");
    const limpiarBtn = document.getElementById("limpiar-filtros-productos");

    console.log("Nombre input encontrado:", nombreInput);
    console.log("Limpiar botón encontrado:", limpiarBtn);

    if (nombreInput) {
        nombreInput.addEventListener("input", () => {
            clearTimeout(window.searchTimer);
            window.searchTimer = setTimeout(filtro, 300);
        });
    }

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
        console.error("No se encontró el botón limpiar-filtros-productos");
    }

    document.addEventListener("click", function (e) {
        if (e.target.matches(".pagination a")) {
            e.preventDefault();

            const url = new URL(e.target.href);
            const formData = new FormData(form);

            // Mantener todos los filtros junto con el page
            formData.forEach((value, key) => {
                url.searchParams.set(key, value);
            });

            fetch(url.toString(), {
                headers: { "X-Requested-With": "XMLHttpRequest" },
            })
                .then((res) => res.text())
                .then((html) => {
                    document.getElementById("tabla-productos").innerHTML = html;
                    if (typeof window.asignarEventosBotones === "function") {
                        window.asignarEventosBotones();
                    }
                });
        }
    });
    const pdfBtn = document.querySelector(".pdfGenerar");

    if (pdfBtn) {
        pdfBtn.addEventListener("click", function (e) {
            e.preventDefault();

            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();

            const pdfUrl = `/admin/productos/pdf?${params}`;

            window.location.href = pdfUrl;
        });
    }
});
