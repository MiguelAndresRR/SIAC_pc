<div class="container-modal-crear-detallesVentas">
    <div class="registrar-detallesVentas-container">
        <h2>Registrar Detalle Compra</h2>
        <form action="{{ route('admin.detallesVentas.store', ['id_venta' => $venta->id_venta]) }}" method="POST">
            @csrf
            <input type="hidden" name="id_venta" value="{{ $id_venta }}">
            <label for="nombre_producto"><i class="fa-solid fa-cubes" style="color: #8b542f;"></i>Producto</label>
            <select id="productoSelectCrear" name="id_producto" required class="form-control">
                <option value="">Buscar producto...</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id_producto }}" data-precio="{{ $producto->precio_producto }}">
                        {{ $producto->nombre_producto }} -
                        {{ $producto->unidad->unidad_peso ?? 'Sin unidad' }}
                    </option>
                @endforeach
            </select><br>
            <label for="cantidad_venta"><i class="fa-solid fa-box-open"
                    style="color: #f86300a9;"></i></i>Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad_venta"
                value="{{ old('cantidad_venta') }}" placeholder="cantidad comprada" required><br>
            <button type="submit">Crear</button>
        </form>
        <button type="button" class="btn" id="ocultar-modal-crear-detallesVentas">Cancelar</button>
    </div>
</div>
<script src="{{ asset('js/detallesVentas/crear.js') }}"></script>
<script>
    document.getElementById('productoSelectCrear').addEventListener('change', function() {
        let precio = this.options[this.selectedIndex].getAttribute('data-precio');
        document.getElementById('precio_producto').value = precio ? precio : '';
        document.getElementById('precio_unitario').value = precio ? precio : '';
    });
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#productoSelectCrear', {
            plugins: ['remove_button'],
            maxItems: 1,
            allowEmptyOption: true,
            create: false,
            dropdownClass: 'ts-dropdown',
            controlInput: '<input>',
        });
    });
</script>
