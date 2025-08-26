document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-agregar')) {
        let id_venta = e.target.getAttribute('data-id_venta');
        window.location.href = `/admin/ventas/${id_venta}/detalles`;
    }
});
