<div class="container-modal-editar-detallesCompras">
    <div class="modificar-detallesCompras-container">
        <h2>Modificar Compra</h2>
        <form id="form_editar-detallesCompras" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" id="id_compra_edit" name="id_compra" value="">
            <label for="nombre_producto"><i class="fa-solid fa-cubes"></i>Producto</label>
            <select id="productoSelect1" name="id_producto" required class="form-control">
                <option value="">Buscar producto...</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id_producto }}">
                        {{ $producto->nombre_producto }} - {{ $producto->unidad->unidad_peso ?? 'Sin unidad' }}
                    </option>
                @endforeach
            </select>

            <label for="cantidad_producto"><i class="fa-solid fa-cubes"></i>Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad_producto"
                value="{{ old('cantidad_producto') }}" placeholder="cantidad comprada" required><br>
            <label for="precio_unitario"><i class="fa-solid fa-dollar-sign"></i>Precio Unidad</label>
            <input type="number" class="form-control" id="precio_unitario_edit" name="precio_unitario"
                value="{{ old('precio_unitario') }}" placeholder="Precio unitario producto..." required><br>
            <button type="submit">Crear</button>
        </form>
        <button type="submit" class="btn" id="ocultar-modal-editar-detallesCompras">Salir</button>
    </div>
</div>

<script src="{{ asset('js/detallesCompras/editar.js') }}"></script>
