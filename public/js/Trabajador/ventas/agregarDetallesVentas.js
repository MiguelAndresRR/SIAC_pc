//Nos re diregue a la vista de detalles de venta 
//con el id de la venta que se haya seleccionado.
document.addEventListener('click', function(e) {
    let btn = e.target.closest('.btn-agregar');
    if (btn) {
        let id_venta = btn.getAttribute('data-id_venta');
        window.location.href = `/user/ventas/${id_venta}/detalles`;
    }
});