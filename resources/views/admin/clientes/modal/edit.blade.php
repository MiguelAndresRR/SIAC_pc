<div class="container-modal-editar-clientes" id="container-modal-editar-clientes">
    <div class="modificar-clientes-container">
        <h2>Editar Cliente</h2>
        <form id="form_editar-clientes" method="POST" enctype="multipart/form-data" action="">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group">
                    <label for="nombre_cliente-editar"><i class="fa-solid fa-user"></i> Nombre</label>
                    <input  value="{{ old('nombre_cliente') }}" type="text" id="nombre_cliente-editar" name="nombre_cliente" required>
                </div>

                <div class="form-group">
                    <label for="apellido_cliente-editar"><i class="fa-solid fa-user"></i> Apellido</label>
                    <input type="text" value="{{ old('apellido_cliente') }}" id="apellido_cliente-editar" name="apellido_cliente" required>
                </div>

                <div class="form-group">
                    <label for="documento_cliente-editar"><i class="fa-solid fa-id-card"></i> Documento</label>
                    <input type="text" value="{{ old('documento_cliente') }}" id="documento_cliente-editar" name="documento_cliente" required>
                </div>

                <div class="form-group">
                    <label for="telefono_cliente-editar"><i class="fa-solid fa-phone"></i> Teléfono</label>
                    <input type="text" value="{{ old('telefono_cliente') }}" id="telefono_cliente-editar" name="telefono_cliente" required>
                </div>

                <div class="form-group">
                    <label for="direccion_cliente-editar"><i class="fa-solid fa-location-dot"></i> Dirección</label>
                    <input type="text" value="{{ old('direccion_cliente') }}" id="direccion_cliente-editar" name="direccion_cliente" required>
                </div>

                <div class="form-group">
                    <label for="correo_cliente-editar"><i class="fa-solid fa-envelope"></i> Correo</label>
                    <input type="email"  value="{{ old('correo_cliente') }}" id="correo_cliente-editar" name="correo_cliente" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <button type="button" class="btn btn-secondary" id="ocultar-modal-editar-clientes">Cancelar</button>
        </form>
    </div>
</div>
