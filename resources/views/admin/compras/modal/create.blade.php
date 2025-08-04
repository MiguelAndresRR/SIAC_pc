<div class="container-modal-crear-compras">
    <div class="registrar-compras-container">
        <h2>Registrar Compra</h2>
        <form action="{{ route('admin.compras.store') }}" method="POST" enctype="multipart/form-data"
            id="formularioCompras" class="necesita-validacion">
            @csrf
            <div class="datos-compra">
                <label for="nombre_usuario">Usuario: {{ Auth::user()->user }} </label>
                <input type="date" name="fecha_compra" id="fecha_compra" class="form-control"
                    value="{{ date('Y-m-d') }}">
                {{-- <label for="total_compra">Total de la compra: {{ $total_compra }}</label> --}}
            </div>
            <div class="detalle-compra">
                <div class="container-compras-class">
                    <table class="tableFixHead">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Proveedor</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
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
                                    <td>{{ $compra->nombre_producto }}</td>
                                    <td>{{ $compra->nombre_proveedor }}</td>
                                    <td>{{ $compra->cantidad }}</td>
                                    <td>{{ $compra->precio_unitario }}</td>
                                    <td>{{ $compra->subtotal }}</td>
                                    <td id="botones">
                                        <button type="button" class="btn-ver" data-id_compra="{{ $compra->id_compra }}"
                                            data-id_detalle_compra="{{ $compra->id_detalle_compra }}">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                        <button type="button" class="btn-editar"
                                            data-id_compra="{{ $compra->id_compra }}"
                                            data-id_detalle_compra="{{ $compra->id_detalle_compra }}">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <button type="button" class="borrar-boton btn btn-danger"
                                            data-id_compra="{{ $compra->id_compra }}"
                                            data-id_detalle_compra="{{ $compra->id_detalle_compra }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                        @if ($compra->id_compra && $compra->id_detalle_compra)
                                            <form
                                                id="formEliminar{{ $compra->id_compra }}_{{ $compra->id_detalle_compra }}"
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
            </div>
            <button type="submit">Crear</button>
        </form>
        <button type="button" class="btn" id="ocultar-modal-crear-compras">Cancelar</button>

    </div>
</div>
<script src="{{ asset('js/compras/crear.js') }}"></script>
