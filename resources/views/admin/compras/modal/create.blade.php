<div class="container-modal-crear-compras">
    <div class="registrar-compras-container">
        <h2>Registrar Compra</h2>
        <form action="{{ route('admin.compras.store') }}" method="POST" enctype="multipart/form-data"
            id="formularioCompras" class="necesita-validacion">
            @csrf
            <div class="datos-compra">
                <label for="nombre_usuario">Usuario: {{ Auth::user()->user }} </label>
                <input type="date" name="fecha_compra" id="fecha_compra" class="form-control"
                    value="{{ date('Y-m-d') }}">
            </div>
            <button type="submit">Crear</button>
        </form>
        <button type="button" class="btn" id="ocultar-modal-crear-compras">Cancelar</button>

    </div>
</div>
<script src="{{ asset('js/compras/crear.js') }}"></script>
