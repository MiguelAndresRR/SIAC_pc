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
            @foreach ($detallesInventario as $inventario)
                <tr>
                    <td>{{ $inventario->detallesCompra->id_detalle_compra }}</td>

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
    @include('admin.inventario.layoutinventario.paginacionDet')
</div>
<script src="{{ asset('js/inventario/verDetalles.js')}}"></script>