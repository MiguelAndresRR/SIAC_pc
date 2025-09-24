//Nos re diregue a la vista de detalles de compra 
//con el id de la compra que se haya seleccionado.
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-agregar')) {
        let id_compra = e.target.getAttribute('data-id_compra');
        window.location.href = `/user/compras/${id_compra}/detalles`;
    }
});
