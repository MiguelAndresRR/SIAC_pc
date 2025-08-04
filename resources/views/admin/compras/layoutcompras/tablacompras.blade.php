<div class="container-compras-class">
    <table class="tableFixHead">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Fecha</th>
                <th>Total</th>
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
                    <td data-id_compra="{{ $compra->id_producto }}" data-id_detalle_compra="{{ $compra->id_detalle_compra }}">
                        {{ $compra->id_compra }}
                    </td>

                    <td id="botones">
                        <button type="button" class="btn-ver" data-id_compra="{{ $compra->id_compra }}"
                            data-id_detalle_compra="{{ $compra->id_detalle_compra }}">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" class="btn-editar" data-id_compra="{{ $compra->id_compra }}"
                            data-id_detalle_compra="{{ $compra->id_detalle_compra }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="borrar-boton btn btn-danger"
                            data-id_compra="{{ $compra->id_compra }}"
                            data-id_detalle_compra="{{ $compra->id_detalle_compra }}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        @if ($compra->id_compra && $compra->id_detalle_compra)
                            <form id="formEliminar{{ $compra->id_compra }}_{{ $compra->id_detalle_compra }}"
                                method="POST"
                                action="{{ route('admin.compras.destroy', [$compra->id_compra, $compra->id_detalle_compra]) }}"
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
