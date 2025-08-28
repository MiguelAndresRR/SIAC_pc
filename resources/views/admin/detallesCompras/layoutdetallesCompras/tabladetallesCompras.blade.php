<div class="container-detallesCompras-class">
    <table class="tableFixHead">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio Unidad</th>
                <th>Total</th>
                <th> Vencimiento </th>
                <th>
                    <button type="submit" class="btn" id='crear-modal-detallesCompras'>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody id="container-detallesCompras-table">
            @foreach ($detallesCompras as $detalles)
                <tr>
                    <td>{{ $detalles->producto->nombre_producto }}</td>
                    <td>{{ $detalles->cantidad_producto }}</td>
                    <td>{{ $detalles->precio_unitario }}</td>
                    <td>{{ $detalles->subtotal_compra }}</td>
                    <td>{{ $detalles->fecha_vencimiento ?? 'sin fecha'}}</td>
                    <td id="botones">
                        <button type="button" class="btn-editar"  data-id_compra="{{ $id_compra }}" data-id_detalle_compra="{{ $detalles->id_detalle_compra }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="borrar-boton btn btn-danger"
                            data-id_detalle_compra="{{ $detalles->id_detalle_compra }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        @if ($detalles->id_detalle_compra)
                            <form id="formEliminar{{ $detalles->id_detalle_compra }}" method="POST"
                                action="{{ route('admin.detallesCompras.destroy', $detalles->id_detalle_compra) }}" style="display: none;">
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
