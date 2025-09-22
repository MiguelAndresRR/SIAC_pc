//Estafuncion nos permite ir a ver los detalles del inventario con el id que seleccionamos. 
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-detalleInventario')) {
        let id_producto = e.target.getAttribute('data-id_producto');
        window.location.href = `/admin/inventario/${id_producto}/detalles`;
    }
});
