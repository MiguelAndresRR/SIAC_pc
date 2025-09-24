<div class="container-detallesVentas-class">
    <table class="tableFixHead">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unidad</th>
                <th>Total</th>
                <th>
                    <button type="submit" class="btn" id='crear-modal-detallesVentas'>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody id="container-detallesVentas-table">
            @foreach ($detallesVentas as $detalles)
                <tr>
                    <td>{{ $detalles->producto->nombre_producto}} - {{ $detalles->producto->categoria->categoria }}</td>
                    <td>{{ $detalles->cantidad_venta}}</td>
                    <td>COP{{ $detalles->precio_unitario_venta}}</td>
                    <td>COP{{ $detalles->subtotal_venta}}</td>
                    <td id="botones">
                        <button type="button" class="btn-agregar"  data-id_venta="{{ $id_venta }}" data-id_detalle_venta="{{ $detalles->id_detalle_venta }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="borrar-boton btn btn-danger"
                            data-id_detalle_venta="{{ $detalles->id_detalle_venta }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        @if ($detalles->id_detalle_venta)
                            <form id="formEliminar{{ $detalles->id_detalle_venta }}" method="POST"
                                action="{{ route('admin.detallesVentas.destroy', $detalles->id_detalle_venta) }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="paginacion">
    @include('user.detallesVentas.layoutdetallesVentas.paginacion')
</div>
