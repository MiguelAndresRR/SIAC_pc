<div class="container-modal-editar2" id="container-modal-editar2" >
    <div class="modificar-usuario-container">
        <h2>Modificar usuario</h2>
        <form id="form_editar1" method="POST" enctype="multipart/form-data" action="">
            @csrf
            @method('PUT')
            <div class="contenedor-doble">
                <div class="form-group datosPersonales">
                    <h2>Datos Personales</h2>
                    <label for="nombre_usuario-editar" class="form-label"><i class="fa-solid fa-user"></i> Nombre</label>
                    <input type="text" class="form-control" id="nombre_usuario-editar" name="nombre_usuario"
                        value="{{ old('nombre_usuario-editar')}}" placeholder="Nombre"
                        maxlength="50" required>

                    <label for="apellido_usuario-editar" class="form-label"><i class="fa-solid fa-user"></i> Apellido</label>
                    <input type="text" class="form-control" id="apellido_usuario-editar" name="apellido_usuario"
                        value="{{ old('apellido_usuario') }}" placeholder="Apellido"
                        maxlength="50" required>
                        
                    <label for="documento_usuario-editar" class="form-label"><i class="fa-solid fa-id-card"></i>
                        Documento</label>
                    <input type="number" class="form-control" id="documento_usuario-editar" name="documento_usuario"
                        value="{{ old('documento_usuario') }}"
                        placeholder="Número de documento" required>

                    <label for="telefono_usuario-editar" class="form-label"><i class="fa-solid fa-phone"></i> Teléfono</label>
                    <input type="tel" class="form-control" id="telefono_usuario-editar" name="telefono_usuario"
                        value="{{ old('telefono_usuario') }}" placeholder="Teléfono"
                        maxlength="10" pattern="[0-9]{7,10}" required>

                    <label for="correo_usuario-editar" class="form-label"><i class="fa-solid fa-envelope"></i> Correo</label>
                    <input type="email" class="form-control" id="correo_usuario-editar" name="correo_usuario"
                        value="{{ old('correo_usuario') }}" placeholder="Correo electrónico"
                        maxlength="50" required>
                </div>
                <div class="form-group datosAcceso">
                    <h2>Datos de Acceso</h2>
                    <label for="user-editar" class="form-label"><i class="fa-solid fa-user"></i> Usuario</label>
                    <input type="text" class="form-control" id="user-editar" name="user" placeholder="Usuario"
                        value="{{ old('user') }}" maxlength="50" required>

                    <label for="password-editar" class="form-label"><i class="fa-solid fa-lock"></i> Contraseña</label>
                    <input type="password" class="form-control" id="password-editar" name="password" placeholder="Contraseña"
                        value="{{ old('password') }}" required minlength="8" maxlength="60"
                        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}"
                        title="Debe contener al menos una letra mayúscula, un carácter especial y mínimo 8 caracteres.">

                    <label for="id_rol-editar" class="form-label"><i class="fa-solid fa-user-tag"></i> Rol</label>
                    <select name="id_rol" id="id_rol-editar" class="form-control" required>
                        <option value="" disabled {{ old('id_rol') ? '' : 'selected' }}>
                            Selecciona rol
                        </option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id_rol }}"
                                {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>
                                {{ $rol->nombre_rol }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-success">Actualizar</button>
            <p class="error" id="errorMessage"></p>
            <button type="button" class="btn btn-secondary" id="ocultar-modal-editar2">Cancelar</button>
        </form>
    </div>
</div>
