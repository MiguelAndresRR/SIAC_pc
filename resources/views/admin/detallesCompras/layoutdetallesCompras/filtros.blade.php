<form id="filtro-form-detallesCompras" method="GET" data-id-compra="{{ $id_compra}}">
    @csrf
    <div class="filtros">
        <select id="productoSelect" name="productoSelect" class="form-control">
            <option value="">Buscar producto...</option>
            @foreach ($productos as $producto)
                <option value="{{ $producto->id_producto }}">{{ $producto->nombre_producto }}</option>
            @endforeach
        </select>
        <select name="PorPagina" id="entries" class="form-control">
            <option disabled selected>Selecciona datos a mostrar</option>
            <option value="10" {{ request('PorPagina') == 10 ? 'selected' : '' }}>10</option>
            <option value="15" {{ request('PorPagina') == 15 ? 'selected' : '' }}>15</option>
            <option value="20" {{ request('PorPagina') == 20 ? 'selected' : '' }}>20</option>
            <option value="25" {{ request('PorPagina') == 25 ? 'selected' : '' }}>25</option>
            <option value="30" {{ request('PorPagina') == 30 ? 'selected' : '' }}>30</option>
        </select>
        <button name="form-control" type="button" id="limpiar-filtros-detallesCompras" ><i
                class="fa-solid fa-eraser" style="color: #ffffff;"></i></button>
    </div>
</form>
<script src="{{ asset('js/detallesCompras/filtrar.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#productoSelect', {
            placeholder: 'Buscar producto...',
            plugins: ['remove_button'],
            maxItems: 1,
            allowEmptyOption: true,
            create: false,
            dropdownClass: 'ts-dropdown',
            controlInput: '<input>',
        });
    });
</script>
