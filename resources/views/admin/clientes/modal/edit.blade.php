<div class="container-modal-editar-clientes" id="container-modal-editar-clientes">
    <div class="registrar-clientes-container">
        <h2>Editar Cliente</h2>
        <form id="form_editar-clientes" method="POST" enctype="multipart/form-data" action="">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group__cliente" id="grupo__nombre_edit">
                    <label for="nombre_cliente-editar"><i class="fa-solid fa-user"></i> Nombre</label>
                    <input type="text" id="nombre_cliente-editar" name="nombre_cliente" required>
                    <p class="alertaInput">Debe tener de a 4-20 caracteres sin simbolos especiales</p>
                </div>

                <div class="form-group__cliente" id="grupo__apellido_edit">
                    <label for="apellido_cliente-editar"><i class="fa-solid fa-user"></i> Apellido</label>
                    <input type="text" id="apellido_cliente-editar" name="apellido_cliente" required>
                    <p class="alertaInput">Debe tener de a 4-20 caracteres sin simbolos especiales</p>
                </div>

                <div class="form-group__cliente" id="grupo__documento_edit">
                    <label for="documento_cliente-editar"><i class="fa-solid fa-id-card"></i> Documento</label>
                    <input type="text" id="documento_cliente-editar" name="documento_cliente" required>
                    <p class="alertaInput">Debe de 1 a 10 digitos, sin simbolos especiales</p>
                </div>

                <div class="form-group__cliente" id="grupo__telefono_edit">
                    <label for="telefono_cliente-editar"><i class="fa-solid fa-phone" style="color: #ff0000;"></i>
                        Teléfono</label>
                    <input type="text" id="telefono_cliente-editar" name="telefono_cliente" required>
                    <p class="alertaInput">Debe de 1 a 10 digitos, sin simbolos especiales</p>
                </div>

                <div class="form-group">
                    <label for="direccion_cliente-editar"><i class="fa-solid fa-location-dot"></i> Dirección</label>
                    <input type="text" id="direccion_cliente-editar" name="direccion_cliente" required>
                </div>
                <div class="form-group">
                    <label for="correo_cliente-editar"><i class="fa-solid fa-envelope" style="color: #ffe282;"></i>
                        Correo</label>
                    <input type="email" id="correo_cliente-editar" name="correo_cliente" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Actualizar</button>
            <button type="button" class="btn btn-secondary" id="ocultar-modal-editar-clientes">Cancelar</button>
        </form>
    </div>
</div>
