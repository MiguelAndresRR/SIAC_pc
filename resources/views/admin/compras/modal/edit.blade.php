<div class="container-modal-editar-compras">
    <div class="modificar-compras-container">
        <h2>Modificar Compra</h2>
        <form id="form_editar-compras" method="POST" enctype="multipart/form-data" action="">
            @csrf
            @method('PUT')
            <label for="user"><i class="fa-solid fa-cubes" style="color: #8b542f;"></i>Usuario</label>
            <input type="text" class="form-control" id="user" name="user"
                value="" readonly ><br>
            <label for="fecha_compra"><i class="fa-regular fa-calendar-days"></i>Fecha de compra:</label>
            <input type="date" class="form-control" id="fecha_compra" name="fecha_compra"
                value="{{ date('Y-m-d') }}" required><br>
            <label for="id_proveedor"><i class="fa-solid fa-truck"></i>Proveedor</label>
            <select name="id_proveedor" id="id_proveedor" class="form-control" required>
                <option value="" disabled selected>Selecciona proveedor</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id_proveedor }}">
                        {{ $proveedor->nombre_proveedor }}
                    </option>
                @endforeach
            </select><br>
            <button type="submit">Actualizar</button>
            <p class="error" id="errorMessage"></p>
        </form>
        <button type="submit" class="btn" id="ocultar-modal-editar-compras">Salir</button>
    </div>
</div>

<script src="{{ asset('js/compras/editar.js') }}"></script>