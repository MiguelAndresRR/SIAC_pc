<div class="container-modal-editar-detallesCompras">
    <div class="modificar-detallesCompras-container">
        <h2>Modificar Compra</h2>
        <form id="form_editar-detallesCompras" method="POST" enctype="multipart/form-data" action="">
            @csrf
            @method('PUT')
            <label for="user">Usuario:</label>
            <input type="text" class="form-control" id="user" name="user"
                value="" readonly ><br>
            <label for="fecha_compra">Fecha de compra:</label>
            <input type="date" class="form-control" id="fecha_compra" name="fecha_compra"
                value="{{ date('Y-m-d') }}" required><br>
            <label for="id_proveedor">Proveedor:</label>
            <button type="submit">Guardar</button>
            <p class="error" id="errorMessage"></p>
        </form>
        <button type="submit" class="btn" id="ocultar-modal-editar-detallesCompras">Salir</button>
    </div>
</div>

<script src="{{ asset('js/detallesCompras/editar.js') }}"></script>