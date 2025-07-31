document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("filtro-form-proveedor");

    function filtro() {
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();

        fetch(`/admin/proveedor?${params}`, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((res) => res.text())
            .then((html) => {
                document.getElementById("tabla-proveedor").innerHTML = html;

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
        .getElementById("buscar_proveedor_nombre")
        .addEventListener("input", () => {
            clearTimeout(window.searchTimer);
            window.searchTimer = setTimeout(filtro, 50);
        });

    document
        .getElementById("buscar_proveedor_nit")
        .addEventListener("input", () => {
            clearTimeout(window.searchTimer);
            window.searchTimer = setTimeout(filtro, 50);
        });

    document
        .getElementById("limpiar-filtros-proveedor")
        .addEventListener("click", function () {
            form.reset();
            filtro();
        });

    document.addEventListener("click", function (e) {
        if (e.target.matches(".pagination a")) {
            e.preventDefault();
            const url = e.target.getAttribute("href");

            fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((res) => res.text())
                .then((html) => {
                    document.getElementById("tabla-proveedor").innerHTML = html;

                    if (typeof window.asignarEventosBotones === "function") {
                        console.log(
                            "Reasignando eventos a .btn-ver (paginación)"
                        );
                        window.asignarEventosBotones();
                    }
                });
        }
    });
});
