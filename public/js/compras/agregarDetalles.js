document.querySelectorAll('.btn-agregar').forEach(boton => {
    boton.addEventListener('click', function() {
        let id_compra = this.getAttribute('data-id_compra');
        window.location.href = `/admin/detallesCompras/${id_compra}`;
    });
});