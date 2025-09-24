<div class="container-compras-class">
    <table class="tableFixHead">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Total Compra</th>
                <th>
                    <button type="submit" class="btn" id='crear-modal-compras'>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </th>
            </tr>
        </thead>
        <tbody id="container-compras-table">
            @foreach ($compras as $compra)
                <tr>
                    <td>{{ $compra->id_compra }}</td>
                    <td>{{ $compra->usuario->user }}</td>
                    <td>{{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y') }}</td>
                    <td>{{ $compra->proveedor->nombre_proveedor }}</td>
                    <td>
                        @if ($compra->total_compra == 0)
                            sin compras
                        @else
                            COP{{ number_format($compra->total_compra, 2) }}
                        @endif
                    </td>
                    <td id="botones">
                        <button type="button" class="btn-agregar" data-id_compra="{{ $compra->id_compra }}">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                        <button type="button" class="btn-editar" data-id_compra="{{ $compra->id_compra }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="borrar-boton btn btn-danger"
                            data-id_compra="{{ $compra->id_compra }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        @if ($compra->id_compra)
                            <form id="formEliminar{{ $compra->id_compra }}" method="POST"
                                action="{{ route('admin.compras.destroy', $compra->id_compra) }}"
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
    @include('admin.compras.layoutcompras.paginacion')
</div>
<script src="{{ asset('js/compras/borrar.js') }}"></script>
<script src="{{ asset('js/compras/agregarDetallesCompras.js') }}"></script>
