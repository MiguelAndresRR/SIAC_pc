<div class="container-inventario-class">
    <table class="tableFixHead">
        <thead>
            <tr>
                <th>Codigo</th>
                <th>Producto</th>
                <th>Stock</th>
                <th>Lotes</th>
            </tr>
        </thead>
        <tbody id="container-inventario-table">
            @foreach ($inventarioProductos as $inventario)
                <tr>
                    <td>{{ $inventario->producto->id_producto }}</td>
                    <td>{{ $inventario->producto->nombre_producto }}</td>
                    <td>
                        @if ($inventario->stock_total <= 0)
                            <span
                                class="inline-block px-3 py-1 rounded-lg text-white bg-red-600 text-sm font-bold shadow-md">
                                Sin stock ({{ $inventario->stock_total }})
                            </span>
                        @elseif ($inventario->stock_total <= 5)
                            <span
                                class="inline-block px-3 py-1 rounded-lg text-yellow-800 bg-yellow-300 text-sm font-bold shadow-md">
                                Poco stock ({{ $inventario->stock_total }})
                            </span>
                        @else
                            <span
                                class="inline-block px-3 py-1 rounded-lg text-green-800 bg-green-300 text-sm font-bold shadow-md">
                                {{ $inventario->stock_total }}
                            </span>
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
<script src="{{ asset('js/inventario/verDetalles.js') }}"></script>
