<div class="container-modal-crear-detallesCompras">
    <div class="registrar-detallesCompras-container">
        <h2>Registrar Compra</h2>
        <form action="{{ route('admin.detallesCompras.store') }}" method="POST" enctype="multipart/form-data"
            id="formulario_detallesCompras" class="necesita-validacion">
            @csrf
            <label for="nombre_producto"><i class="fa-solid fa-cubes"></i>Producto</label>
            <input type="text" class="form-control" id="nombre_producto" name="nombre_producto"
                value="{{ old('nombre_producto') }}" placeholder="nombre del producto" required><br>
            <label for="cantidad"><i class="fa-solid fa-cubes"></i>Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad"
                value="{{ old('cantidad') }}" placeholder="cantidad comprada" required><br>
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
