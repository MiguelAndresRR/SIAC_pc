<form id="filtro-form-detallesCompras" method="GET">
    @csrf
    <div class="filtros">
        <input type="hidden" name="id_compra" id="idCompra" value="{{ $id_compra }}">
        <div class="buscador-con-icono">
            <i class="fa-solid fa-magnifying-glass"></i>
            <select id="productoSelect" name="id_producto">
                <option value="" selected disabled>Seleccione un producto</option>
                @foreach ($productos as $producto)
                    <option value="{{ $producto->id_producto }}">{{ $producto->nombre_producto }}</option>
                @endforeach
            </select>
        </div>

        <select name="PorPagina" id="entries" class="form-control">
            <option disabled selected>Selecciona datos a mostrar</option>
            <option value="10" {{ request('PorPagina') == 10 ? 'selected' : '' }}>5</option>
            <option value="15" {{ request('PorPagina') == 15 ? 'selected' : '' }}>15</option>
            <option value="20" {{ request('PorPagina') == 20 ? 'selected' : '' }}>20</option>
            <option value="25" {{ request('PorPagina') == 25 ? 'selected' : '' }}>25</option>
            <option value="30" {{ request('PorPagina') == 30 ? 'selected' : '' }}>30</option>
        </select>
        <button name="form-control" type="button" id="limpiar-filtros-detallesCompras" class="form-control"><i
                class="fa-solid fa-eraser" style="color: #ffffff;"></i></button>
    </div>
</form>
<script src="{{ asset('js/detallesCompras/filtrar.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new TomSelect('#productoSelect', {
            placeholder: 'Buscar producto...',
            allowEmptyOption: true,
            create: false,
            dropdownClass: 'ts-dropdown',
            controlInput: '<input>',
        });
        render: {
            option: function(data, escape) {
                return `<div class="option-item">${escape(data.text)}</div>`;
            }
        }
    });
</script>
