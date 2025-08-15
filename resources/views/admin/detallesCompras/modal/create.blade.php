<div class="container-modal-crear-detallesCompras">
    <div class="registrar-detallesCompras-container">
        <h2>Registrar Compra</h2>
        <form action="{{ route('admin.detallesCompras.store') }}" method="POST" enctype="multipart/form-data"
            id="formulario_detallesCompras" class="necesita-validacion">
            @csrf
            <label for="nombre_producto"><i class="fa-solid fa-cubes"></i>Producto</label>
                <select id="productoSelect1" name="id_producto" required>
                    <option value="">Buscar producto...</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id_producto }}">{{ $producto->nombre_producto }}</option>
                    @endforeach
                </select>
            <label for="cantidad"><i class="fa-solid fa-cubes"></i>Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" value="{{ old('cantidad') }}"
                placeholder="cantidad comprada" required><br>
            <label for="precio_unidad"><i class="fa-solid fa-dollar-sign"></i>Precio Unidad</label>
            <input type="number" class="form-control" id="precio_unidad" name="precio_unidad"
                value="{{ old('precio_unidad') }}" placeholder="Precio unitario producto..." required><br>
            <label for="sub_total"><i class="fa-solid fa-dollar-sign"></i>Sub Total</label>
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
