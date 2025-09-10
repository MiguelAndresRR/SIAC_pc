<div class="container-inventario-class">
    <table class="tableFixHead">
        <thead>
            <tr>
                <th>Codigo Lote</th>
                <th>Numero Compra</th>
                <th>fecha</th>
                <th>Stock Lote</th>
            </tr>
        </thead>
        <tbody class="tabla_detalle_inventario" id="container-inventario-table" padding="10px">
            @foreach ($detallesInventario as $inventario)
                <tr>
                    <td>{{$inventario->id_detalle_compra}}</td>
                    <td>#{{$inventario->detalleCompra->id_compra }}</td>
                    <td>{{\Carbon\Carbon::parse($inventario->detalleCompra->Compra->fecha_compra)->format('d/m/Y') }}</td>
                    <td>
                        @if ($inventario->stock_lote <= 0)
                            <span class="text-red-600 font-bold">Sin stock ({{ $inventario->stock_lote }})</span>
                        @elseif ($inventario->stock_lote <= 5)
                            <span class="text-yellow-600 font-bold">Poco stock ({{ $inventario->stock_lote }})</span>
                        @else
                            <span class="text-green-600">{{ $inventario->stock_lote }}</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="paginacion">
    @include('admin.detallesInventario.layoutDetallesInventario.paginacion')
</div>
