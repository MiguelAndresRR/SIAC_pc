document.addEventListener('click', function(e) {
    let btn = e.target.closest('.btn-agregar');
    if (btn) {
        let id_venta = btn.getAttribute('data-id_venta');
        window.location.href = `/admin/ventas/${id_venta}/detalles`;
    }
});