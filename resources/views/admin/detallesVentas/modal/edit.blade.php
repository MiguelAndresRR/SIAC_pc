<div class="container-modal-editar-detallesVentas">
    <div class="modificar-detallesVentas-container">
        <h2>Modificar Compra</h2>
        <form id="form_editar-detallesVentas" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" id="id_venta_edit" name="id_venta" value="">
            <label for="nombre_producto"><i class="fa-solid fa-cubes" style="color: #8b542f;"></i>Producto</label>
            <select id="productoSelectEditar" name="id_producto" required class="form-control">
                <option value="">Buscar producto...</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id_producto }}">
                        {{ $producto->nombre_producto }} - {{ $producto->unidad->unidad_peso ?? 'Sin unidad' }}
                    </option>
                @endforeach
            </select><br>
            <label for="cantidad_venta"><i class="fa-solid fa-box-open" style="color: #f86300a9;"></i>Cantidad</label>
            <input  type="number" class="form-control" id="cantidad_venta" name="cantidad_venta"
                value="{{ old('cantidad_venta') }}" placeholder="cantidad vendida" required><br>
            <label for="precio_unitario_venta-edit"><i class="fa-solid fa-dollar-sign" style="color: #006b05;"></i>Precio Unidad</label>
            <input type="number" class="form-control" id="precio_unitario_venta-edit" name="precio_unitario_venta"
                value="{{ old('precio_unitario_venta') }}" placeholder="Precio unitario producto..." required><br>
            <button type="submit">Actualizar</button>
        </form>
        <button type="submit" class="btn" id="ocultar-modal-editar-detallesVentas">Salir</button>
    </div>
</div>

<script src="{{ asset('js/detallesVentas/editar.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#productoSelectEditar', {
            plugins: ['remove_button'],
            maxItems: 1,
            allowEmptyOption: true,
            create: false,
            dropdownClass: 'ts-dropdown',
            controlInput: '<input>',
        });
    });
</script>