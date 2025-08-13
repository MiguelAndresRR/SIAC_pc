<div class="container-detallesCompras-class">
    <table class="tableFixHead">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unidad</th>
                <th>Total</th>
                <th>
                    <button type="submit" class="btn" id='crear-modal-detallesCompras'>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody id="container-detallesCompras-table">
            @foreach ($detallesCompras as $detalleCompra)
                <tr>
                    <td>{{ $detalleCompra->id_detalle_compra }}</td>
                    <td>{{ $detalleCompra->producto->nombre_producto }}</td>
                    <td>{{ $detalleCompra->cantidad }}</td>
                    <td>{{ $detalleCompra->precio_unidad }}</td>
                    <td>{{ $detalleCompra->sub_total }}</td>
                    <td id="botones">
                        <button type="button" class="btn-agregar" data-id_detalle_compra="{{ $detalleCompra->id_detalle_compra }}"
                            data-id_detalle_compra="{{ $detalleCompra->id_detalle_compra }}">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                        <button type="button" class="btn-editar" data-id_detalle_compra="{{ $detalleCompra->id_detalle_compra }}"
                            data-id_detalle_compra="{{ $detalleCompra->id_detalle_compra }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="borrar-boton btn btn-danger"
                            data-id_detalle_compra="{{ $detalleCompra->id_detalle_compra }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        @if ($detallesCompras->id_detalle_compra)
                            <form id="formEliminar{{ $detalleCompra->id_detalle_compra }}" method="POST"
                                action="{{ route('admin.detallesCompras.destroy', $detalleCompra->id_detalle_compra) }}" style="display: none;">
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
    @include('admin.detallesCompras.layoutdetallesCompras.paginacion')
</div>
<script src="{{ asset('js/detallesCompras/borrar.js') }}"></script>
