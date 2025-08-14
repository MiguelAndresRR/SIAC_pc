document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("filtro-form-proveedores");

    function filtro() {
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();

        fetch(`/admin/proveedores?${params}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((res) => res.text())
            .then((html) => {
                document.getElementById("tabla-proveedores").innerHTML = html;

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
            });
    }

    form.addEventListener("change", filtro);

    document
        .getElementById("buscar_proveedores_nombre")
        .addEventListener("input", () => {
            clearTimeout(window.searchTimer);
            window.searchTimer = setTimeout(filtro, 50);
        });

    document
        .getElementById("buscar_proveedores_nit")
        .addEventListener("input", () => {
            clearTimeout(window.searchTimer);
            window.searchTimer = setTimeout(filtro, 50);
        });

    document
        .getElementById("limpiar-filtros-proveedores")
        .addEventListener("click", function () {
            form.reset();
            filtro();
        });

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
                    document.getElementById("tabla-proveedores").innerHTML = html;
                    if (typeof window.asignarEventosBotones === "function") {
                        window.asignarEventosBotones();
                    }
                });
        }
    });
});
