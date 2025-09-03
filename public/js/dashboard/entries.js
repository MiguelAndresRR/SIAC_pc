document.getElementById('entries').addEventListener('change', function () {
    const valor = this.value;
    const categoria = document.getElementById('filtro-categoria').value;
    const unidad = document.getElementById('filtro-unidad').value;
    const buscarProducto = document.getElementById('buscarProducto').value.toLowerCase();

    const params = new URLSearchParams(window.location.search);
    params.set('PorPagina', valor);

    // if (categoria) params.set("categoria", categoria);
    // if (unidad) params.set("unidad", unidad);
    // if (buscarProducto) params.set("buscar", buscar);

    window.location.href = `${window.location.pathname}?${params.toString()}`;
});
