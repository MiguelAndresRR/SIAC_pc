<div class="container-modal-crear-clientes">
    <div class="registrar-clientes-container">
        <h2>Registrar Cliente</h2>
        <form action="{{ route('admin.clientes.store') }}" method="POST" enctype="multipart/form-data"
            id="formularioCliente">
            @csrf
            <div class="form-grid">
                <div class="form-group__cliente" id="grupo__nombre">
                    <label for="nombre_cliente"><i class="fa-solid fa-user"></i>
                        Nombre</label>
                    <input type="text" name="nombre_cliente" id="nombre_cliente" placeholder="Nombre del cliente"
                        required>
                    <p class="alertaInput">Debe tener de a 4-20 caracteres sin simbolos especiales</p>
                </div>

                <div class="form-group__cliente" id="grupo__apellidos">
                    <label for="apellido_cliente"><i class="fa-solid fa-user"></i>
                        Apellido</label>
                    <input type="text" name="apellido_cliente" id="apellido_cliente" placeholder="Apellido del cliente"
                        required>
                    <p class="alertaInput">Debe tener de a 4-20 caracteres sin simbolos especiales</p>
                </div>

                <div class="form-group__cliente" id="grupo__documento">
                    <label for="documento_cliente"><i class="fa-solid fa-id-card"></i> Documento</label>
                    <input type="text" name="documento_cliente" id="documento_cliente" placeholder="Identificación"
                        required>
                    <p class="alertaInput">Debe de 1 a 10 digitos, sin simbolos especiales ni letras</p>
                </div>

                <div class="form-group__cliente" id="grupo__telefono">
                    <label for="telefono_cliente"><i class="fa-solid fa-phone" style="color: #ff0000;"></i>
                        Teléfono</label>
                    <input type="text" name="telefono_cliente" id="telefono_cliente" placeholder="Teléfono" required>
                    <p class="alertaInput">Debe de 1 a 10 digitos, sin simbolos especiales ni letras</p>
                </div>

                <div class=form-group__cliente>
                    <label for="direccion_cliente"><i class="fa-solid fa-location-dot"></i> Dirección</label>
                    <input type="text" name="direccion_cliente" id="direccion_cliente" placeholder="Dirección" required>
                </div>

                <div class=form-group__cliente>
                    <label for="correo_cliente"><i class="fa-solid fa-envelope" style="color: #ffe282;"></i>
                        Correo</label>
                    <input type="email" name="correo_cliente" id="correo_cliente" placeholder="Correo" required>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Crear</button>
        </form>

        <button type="button" class="btn btn-secondary" id="ocultar-modal-crear-clientes">Cancelar</button>
    </div>
</div>