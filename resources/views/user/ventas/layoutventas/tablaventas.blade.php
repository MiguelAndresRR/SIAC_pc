<div class="container-ventas-class">
    <table class="tableFixHead">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Cedula</th>
                <th>Fecha</th>
                <th>Vendedor</th>
                <th>Total Venta</th>
                <th>
                    <button type="submit" class="btn" id='crear-modal-ventas'>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody id="container-ventas-table">
            @foreach ($ventas as $venta)
                <tr>
                    <td>{{ $venta->id_venta }}</td>
                    <td>{{ $venta->cliente->nombre_cliente.' '.$venta->cliente->apellido_cliente}}</td>
                    <td>{{ $venta->cliente->documento_cliente}}</td>
                    <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                    <td>{{ $venta->usuario->user }}</td>
                    <td>COP
                        @if($venta->total_venta == 0)
                            sin ventas
                        @else
                            {{ number_format($venta->total_venta,2)}}
                        @endif
                    </td>
                    <td id="botones">
                        <button type="button" class="btn-agregar" data-id_venta="{{ $venta->id_venta}}">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                        <button type="button" class="btn-editar" data-id_venta="{{ $venta->id_venta }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="borrar-boton btn btn-danger"
                            data-id_venta="{{ $venta->id_venta }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        @if ($venta->id_venta)
                            <form id="formEliminar{{ $venta->id_venta }}" method="POST"
                                action="{{ route('admin.ventas.destroy', $venta->id_venta) }}"
                                style="display: none;">
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
    @include('user.ventas.layoutventas.paginacion')
</div>
<script src="{{ asset('js/Trabajador/ventas/agregarDetallesVentas.js') }}"></script>