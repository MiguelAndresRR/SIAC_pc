<div class="container-modal-crear-detallesCompras">
    <div class="registrar-detallesCompras-container">
        <h2>Registrar Detalle Compra</h2>
        <form action="{{ route('admin.detallesCompras.store', ['id_compra' => $compra->id_compra]) }}" method="POST">
            @csrf
            <input type="hidden" name="id_compra" value="{{ $id_compra }}">
            <label for="nombre_producto"><i class="fa-solid fa-cubes" style="color: #8b542f;"></i>Producto</label>
            <select id="productoSelect2" name="id_producto" required class="form-control">
                <option value="">Buscar producto...</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id_producto }}">
                        {{ $producto->nombre_producto }} -
                        {{ $producto->unidad->unidad_peso?? 'Sin unidad' }}
                    </option>
                @endforeach
            </select><br>
            <label for="cantidad_producto"><i class="fa-solid fa-box-open" style="color: #f86300a9;"></i></i>Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad_producto"
                value="{{ old('cantidad_producto') }}" placeholder="cantidad comprada" required><br>
            <label for="precio_unitario"><i class="fa-solid fa-dollar-sign" style="color: #006b05;"></i>Precio Unidad</label>
            <input type="number" class="form-control" id="precio_unitario" name="precio_unitario"
                placeholder="Precio unitario producto..." required><br>
            <button type="submit">Crear</button>
        </form>
        <button type="button" class="btn" id="ocultar-modal-crear-detallesCompras">Cancelar</button>
    </div>
</div>
<script src="{{ asset('js/detallesCompras/crear.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#productoSelect1', {
            plugins: ['remove_button'],
            maxItems: 1,
            allowEmptyOption: true,
            create: false,
            dropdownClass: 'ts-dropdown',
            controlInput: '<input>',
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#productoSelect2', {
            plugins: ['remove_button'],
            maxItems: 1,
            allowEmptyOption: true,
            create: false,
            dropdownClass: 'ts-dropdown',
            controlInput: '<input>',
        });
    });
</script>