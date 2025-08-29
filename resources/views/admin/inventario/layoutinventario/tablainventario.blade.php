<div class="container-inventario-class">
    <table class="tableFixHead">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Producto</th>
                <th>Stock</th>
                <th>Mas detalles</th>
            </tr>
        </thead>
        <tbody id="container-inventario-table">
            @foreach ($inventarioProductos as $inventario)
                <tr>
                    <td>{{ $inventario->producto->id_producto }}</td>
                    <td>{{ $inventario->producto->nombre_producto }}</td>
                    <td>
                        @if ($inventario->stock <= 0)
                            <span class="text-red-600 font-bold">Sin stock ({{ $inventario->stock }})</span>
                        @elseif ($inventario->stock <= 5)
                            <span class="text-yellow-600 font-bold">Poco stock ({{ $inventario->stock }})</span>
                        @else
                            <span class="text-green-600">{{ $inventario->stock }}</span>
                        @endif
                    </td>

                    <td id="botones">
                        <button type="button" class="btn-detalleInventario"
                            data-id_producto="{{ $inventario->producto->id_producto }}">
                            <i class="fa-solid fa-cubes-stacked"></i>
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="paginacion">
    @include('admin.inventario.layoutinventario.paginacion')
</div>
<script src="{{ asset('js/inventario/verDetalles.js')}}"></script>