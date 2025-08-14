<div class="container-modal-crear-detallesCompras">
    <div class="registrar-detallesCompras-container">
        <h2>Registrar Compra</h2>
        <form action="{{ route('admin.detallesCompras.store') }}" method="POST" enctype="multipart/form-data"
            id="formulario_detallesCompras" class="necesita-validacion">
            @csrf
            <label for="nombre_producto"><i class="fa-solid fa-cubes"></i>Producto</label>
            <div class="search-container-productos" style="position: relative;">
                <div class="input-error-producto">
                    <span id="productoError" style="color: red; font-size: 0.8rem; display: none;">
                        ⚠ El producto no existe
                    </span>
                </div>
                <div class="search-input-box">
                    <input type="text" onkeydown="return event.key !== 'Enter';" placeholder="Buscar producto..."
                        class="form-control">
                    <ul class="conteiner-productos-search" id="itemListProductos">
                        @foreach ($productos as $producto)
                            <li class="search-item" data-id_producto="{{ $producto->id_producto }}"
                                data-nombre_producto="{{ $producto->nombre_producto }}">
                                {{ $producto->nombre_producto }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
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
<script src="{{ asset('js/inputSearchs/inputSearchProductos.js') }}"></script>
