<div class="container-modal-crear-ventas">
    <div class="registrar-ventas-container">
        <h2>Registrar Venta</h2>
        <form action="{{ route('admin.ventas.store') }}" method="POST" enctype="multipart/form-data" id="formularioVentas"
            class="necesita-validacion">
            @csrf
            <label for="clienteSelectCrear"><i class="fa-solid fa-hand-holding-heart"></i> Cliente</label>
            <select  name="id_cliente" id="clienteSelectCrear" >
                <option disabled selected>Clientes</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id_cliente }}">
                        {{ $cliente->nombre_cliente }} {{ $cliente->apellido_cliente }} -
                        {{ $cliente->documento_cliente }}
                    </option>
                @endforeach
            </select><br>
            <label for="id_usuario"><i class="fa-solid fa-cubes" style="color: #8b542f;"></i>Vendedor</label>
            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario"
                value="{{ Auth::user()->user }}" readonly><br>
            <label for="fecha_venta"><i class="fa-regular fa-calendar-days"></i>Fecha de venta:</label>
            <input type="date" name="fecha_venta" id="fecha_venta" class="form-control"
                value="{{ date('Y-m-d') }}"><br>
            <input type="hidden" name="id_usuario" id="id_usuario" class="form-control"
                value="{{ auth::user()->id_usuario }}"><br>
            <button class="button_crear_ventas" type="submit">Crear</button>
        </form>
        <button class="button_crear_ventas" type="button" class="btn"
            id="ocultar-modal-crear-ventas">Cancelar</button>
    </div>
</div>
<script src="{{ asset('js/ventas/crear.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#clienteSelectCrear', {
            placeholder: ['Buscar Cliente'],
            plugins: ['remove_button'],
            maxItems: 1,
            allowEmptyOption: true,
            create: false,
            dropdownClass: 'ts-dropdown',
            controlInput: '<input>',
        });
    });
</script>
