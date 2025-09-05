<div class="container-modal-editar2" id="container-modal-editar2">
    <div class="modificar-usuario-container">
        <h2>Modificar usuario</h2>
        <form id="form_editar1" method="POST" enctype="multipart/form-data" action="">
            @csrf
            @method('PUT')
            <div class="contenedor-doble">
                <!-- DATOS PERSONALES -->
                <div class="datosPersonales">
                    <h2>Datos Personales</h2>
                    <div class="form-grid">
                        <div class="form-group__usuario" id="grupo__usuario_edit">
                            <label for="nombre_usuario-editar" class="form-label"><i class="fa-solid fa-user"></i>
                                Nombre</label>
                            <input type="text" class="form-control" id="nombre_usuario-editar" name="nombre_usuario"
                                value="{{ old('nombre_usuario') }}" placeholder="Nombre" maxlength="50" required>
                            <p class="alertaInput">Debe tener de a 4-20 caracteres sin simbolos especiales</p>
                        </div>

                        <div class="form-group__usuario" id="grupo__apellido_edit">
                            <label for="apellido_usuario-editar" class="form-label"><i class="fa-solid fa-user"></i>
                                Apellido</label>
                            <input type="text" class="form-control" id="apellido_usuario-editar"
                                name="apellido_usuario" value="{{ old('apellido_usuario') }}" placeholder="Apellido"
                                maxlength="50" required>
                            <p class="alertaInput">Debe tener de a 4-20 caracteres sin simbolos especiales</p>
                        </div>

                        <div class="form-group__usuario" id="grupo__documento_edit">
                            <label for="documento_usuario-editar" class="form-label"><i class="fa-solid fa-id-card"></i>
                                Documento</label>
                            <input type="number" class="form-control" id="documento_usuario-editar"
                                name="documento_usuario" value="{{ old('documento_usuario') }}"
                                placeholder="Número de documento"required>
                            <p class="alertaInput">Debe tener de a 4-20 caracteres sin simbolos especiales</p>
                        </div>

                        <div class="form-group__usuario" id="grupo__telefono_edit">
                            <label for="telefono_usuario-editar" class="form-label"><i class="fa-solid fa-phone"></i>
                                Teléfono</label>
                            <input type="number" class="form-control" id="telefono_usuario-editar"
                                name="telefono_usuario" value="{{ old('telefono_usuario') }}" placeholder="Teléfono"
                                required>
                            <p class="alertaInput">Debe tener de a 4-20 caracteres sin simbolos especiales</p>
                        </div>

                        <div class="form-group">
                            <label for="correo_usuario-editar" class="form-label"><i class="fa-solid fa-envelope"></i>
                                Correo</label>
                            <input type="email" class="form-control" id="correo_usuario-editar" name="correo_usuario"
                                value="{{ old('correo_usuario') }}" placeholder="Correo electrónico" maxlength="50"
                                required>
                        </div>
                    </div>
                </div>


                <div class="datosAcceso">
                    <h2>Datos de Acceso</h2>
                    <div class="form-group__usuario" id="grupo__user_edit">
                        <label for="user-editar" class="form-label"><i class="fa-solid fa-user"></i> Usuario</label>
                        <input type="text" class="form-control" id="user-editar" name="user" placeholder="Usuario"
                            value="{{ old('user') }}" maxlength="50" required>
                        <p class="alertaInput">Debe tener de a 4-20 caracteres sin simbolos especiales</p>
                    </div>
                    <label for="password-editar" class="form-label"><i class="fa-solid fa-lock"></i> Contraseña</label>
                    <input type="password" class="form-control" id="password-editar" name="password"
                        placeholder="Contraseña (opcional)" value="" minlength="8" maxlength="60"
                        pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}"
                        title="Debe contener al menos una letra mayúscula, un carácter especial y mínimo 8 caracteres.">

                    <label for="id_rol-editar" class="form-label"><i class="fa-solid fa-user-tag"></i> Rol</label>
                    <select name="id_rol" id="id_rol-editar" class="form-control" required>
                        <option value="" disabled {{ old('id_rol') ? '' : 'selected' }}>Selecciona rol</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->id_rol }}" {{ old('id_rol') == $rol->id_rol ? 'selected' : '' }}>
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
