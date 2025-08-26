<div class="container-modal-editar-ventas">
    <div class="modificar-ventas-container">
        <h2>Modificar Venta</h2>
        <form method="POST" id="form_editar-ventas">
            @csrf
            @method('PUT')
            <label for="id_cliente-editar"><i class="fa-solid fa-hand-holding-heart"></i> Cliente</label>
            <select id="id_cliente-editar" name="id_cliente" required>
                <option value="">Buscar Cliente</option>
                @foreach ($clientes as $cliente)
                    <option value="{{ $cliente->id_cliente }}">
                        {{ $cliente->nombre_cliente }}-
                        {{ $cliente->documento_cliente }}
                    </option>
                @endforeach
            </select><br>
            <label for="id_usuario"><i class="fa-solid fa-cubes" style="color: #8b542f;"></i>Usuario</label>
            <input type="text" class="form-control" id="user" name="id_usuario" value="" readonly><br>
            <label for="fecha_venta"><i class="fa-regular fa-calendar-days"></i>Fecha de compra:</label>
            <input type="date" class="form-control" id="fecha_venta" name="fecha_venta" value="{{ date('Y-m-d') }}"
                required><br>
            <button type="submit">Actualizar</button>
            <button type="submit" class="btn" id="ocultar-modal-editar-ventas">Salir</button>
        </form>
    </div>
</div>

<script src="{{ asset('js/ventas/editar.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        clienteSelect = new TomSelect('#id_cliente-editar', {
            placeholder: 'Buscar Cliente',
            plugins: ['remove_button'],
            maxItems: 1,
            allowEmptyOption: true,
            create: false,
            dropdownClass: 'ts-dropdown',
            controlInput: '<input>',
        });
    });
</script>
