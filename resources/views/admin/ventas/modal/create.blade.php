<div class="container-modal-crear-compras">
    <div class="registrar-compras-container">
        <h2>Registrar Compra</h2>
        <form action="{{ route('admin.compras.store') }}" method="POST" enctype="multipart/form-data"
            id="formularioCompras" class="necesita-validacion">
            @csrf
            <label for="nombre_usuario"><i class="fa-solid fa-cubes" style="color: #8b542f;"></i>Usuario</label>
            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario"
                value="{{ Auth::user()->user }}" readonly><br>
            <label for="fecha_compra"><i class="fa-regular fa-calendar-days" ></i>Fecha de compra:</label>
            <input type="date" name="fecha_compra" id="fecha_compra" class="form-control"
                value="{{ date('Y-m-d') }}"><br>
            <input type="hidden" name="id_usuario" id="id_usuario" class="form-control"
                value="{{ auth::user()->id_usuario }}"><br>
            <label for="id_proveedor"><i class="fa-solid fa-truck"></i>Proveedor</label>
            <select name="id_proveedor" id="id_proveedor" class="form-control" required>
                <option value="" disabled selected>Selecciona proveedor</option>
                @foreach ($proveedores as $proveedor)
                    <option value="{{ $proveedor->id_proveedor }}">
                        {{ $proveedor->nombre_proveedor }}
                    </option>
                @endforeach
            </select><br>
            <input type="hidden" name="id_usuario" id="id_usuario" class="form-control"
                value="{{ Auth::user()->id_usuario }}"><br>
            <button class="button_crear_compra" type="submit">Crear</button>
        </form>
        <button class="button_crear_compra" type="button" class="btn"
            id="ocultar-modal-crear-compras">Cancelar</button>
    </div>
</div>
<script src="{{ asset('js/compras/crear.js') }}"></script>
