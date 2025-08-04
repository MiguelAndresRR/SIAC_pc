<div class="container-modal-editar-proveedores" id="container-modal-editar-proveedores">
    <div class="modificar-proveedores-container">
        <h2>Modificar Proveedor</h2>
        <form id="form_editar-proveedores" method="POST" enctype="multipart/form-data" action="">
            @csrf
            @method('PUT')

            <label for="nombre_proveedor">
                <i class="fa-solid fa-user"></i> Proveedor
            </label>
            <input type="text" class="form-control" id="nombre_proveedor" name="nombre_proveedor"
                value="{{ old('nombre_proveedor') }}" placeholder="Nombre del proveedor" required>

            <label for="telefono_proveedor">
                <i class="fa-solid fa-phone"></i> Teléfono
            </label>
            <input type="text" class="form-control" id="telefono_proveedor" name="telefono_proveedor"
                value="{{ old('telefono_proveedor') }}" placeholder="Teléfono del proveedor" required>

            <label for="nit_proveedor">
                <i class="fa-solid fa-id-card"></i> NIT
            </label>
            <input type="text" class="form-control" id="nit_proveedor" name="nit_proveedor"
                value="{{ old('nit_proveedor') }}" placeholder="NIT del proveedor" required>

            <label for="direccion_proveedor">
                <i class="fa-solid fa-location-dot"></i> Dirección
            </label>
            <input type="text" class="form-control" id="direccion_proveedor" name="direccion_proveedor"
                value="{{ old('direccion_proveedor') }}" placeholder="Dirección del proveedor" required>

            <label for="correo_proveedor">
                <i class="fa-solid fa-envelope"></i> Correo
            </label>
            <input type="text" class="form-control" id="correo_proveedor" name="correo_proveedor"
                value="{{ old('correo_proveedor') }}" placeholder="Correo del proveedor" required><br>

            <button type="submit" class="btn btn-success">
                Actualizar
            </button>
            <p class="error" id="errorMessage"></p>
            <button type="button" class="btn btn-secondary" id="ocultar-modal-editar-proveedores">
                Cancelar
            </button>
        </form>
    </div>
</div>
