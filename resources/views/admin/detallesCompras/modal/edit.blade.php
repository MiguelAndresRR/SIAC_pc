<div class="container-modal-editar-detallesCompras">
    <div class="modificar-detallesCompras-container">
        <h2>Modificar Compra</h2>
        <form id="form_editar-detallesCompras" method="POST" action="">
            @csrf
            @method('PUT')
            <input type="hidden" id="id_compra_edit" name="id_compra" value="">
            <label for="nombre_producto"><i class="fa-solid fa-cubes" style="color: #8b542f;"></i>Producto</label>
            <select id="productoSelect1" name="id_producto" required class="form-control">
                <option value="">Buscar producto...</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id_producto }}">
                        {{ $producto->nombre_producto }} - {{ $producto->unidad->unidad_peso ?? 'Sin unidad' }}
                    </option>
                @endforeach
            </select><br>
            <label for="cantidad_producto"><i class="fa-solid fa-box-open"
                    style="color: #f86300a9;"></i>Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad_producto"
                value="{{ old('cantidad_producto') }}" placeholder="cantidad comprada" required><br>
            <label for="fecha_vencimiento"><i class="fa-solid fa-calendar-days" style="color: #0051f4;"></i>Fecha
                Vencimiento</label>
            <input type="date" class="form-control" id="fecha_vencimiento" name="fecha_vencimiento"
                value="{{ old('fecha_vencimiento') }}" placeholder="Fecha de vencimiento"><br>
            <label for="precio_unitario"><i class="fa-solid fa-dollar-sign" style="color: #006b05;"></i>Precio
                Unidad</label>
            <input type="number" class="form-control" id="precio_unitario_edit" name="precio_unitario"
                value="{{ old('precio_unitario') }}" placeholder="Precio unitario producto..." required><br>
            <button type="submit">Actualizar</button>
        </form>
        <button type="submit" class="btn" id="ocultar-modal-editar-detallesCompras">Salir</button>
    </div>
</div>

<script src="{{ asset('js/detallesCompras/editar.js') }}"></script>
