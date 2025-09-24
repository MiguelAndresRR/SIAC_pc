//Este script en JavaScript se ejecuta al cargar el DOM y se encarga de gestionar los filtros dinámicos de los productos en una tabla. Primero, 
// obtiene el formulario de filtros y define la función filtro(), que envía los datos del formulario al servidor mediante fetch con AJAX, 
// actualizando la tabla de los productos sin recargar la página. Además, 
// agrega eventos a los campos de búsqueda para ejecutar el filtro automáticamente tras un breve retraso al escribir, 
// y al botón de limpiar para reiniciar los filtros y recargar los resultados. 
// También intercepta los clics en los enlaces de paginación para mantener los filtros activos mientras se navega entre páginas. 
// Finalmente, después de cada actualización de la tabla, 
// vuelve a asignar los eventos necesarios a los botones de acciones (como ver o crear) si estas funciones globales están definidas.
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

            const pdfUrl = `/user/productos/pdf?${params}`;

            window.location.href = pdfUrl;
        });
    }
});
