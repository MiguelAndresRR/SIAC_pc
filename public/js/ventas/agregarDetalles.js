document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-agregar')) {
        let id_compra = e.target.getAttribute('data-id_compra');
        window.location.href = `/admin/compras/${id_compra}/detalles`;
    }
});
