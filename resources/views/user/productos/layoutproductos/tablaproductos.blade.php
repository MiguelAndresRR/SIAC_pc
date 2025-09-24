<div class="container-productos-class">
    <table class="tableFixHead">
        <thead>
            <tr>
                <th>ID</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Categoria</th>
                <th>Unidad Medida</th>
                <th>
                    <button type="submit" class="btn" id='crear-modal-productos'>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </th>

            </tr>
        </thead>
        <tbody id="container-productos-table">
            @foreach ($productos as $producto)
                <tr>
                    <td>{{ $producto->id_producto }}</td>
                    <td>{{ $producto->nombre_producto }}</td>
                    <td>COP{{ $producto->precio_producto }}</td>
                    <td data-id-categoria="{{ $producto->id_categoria_producto }}">{{ $producto->categoria->categoria }}
                    </td>
                    <td data-id-unidad="{{ $producto->id_unidad_peso_producto }}">{{ $producto->unidad->unidad_peso }}
                    </td>

                    <td id="botones">
                        <button type="submit" class="btn-ver" data-id_producto="{{ $producto->id_producto }}">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="submit" class="btn-editar" data-id_producto="{{ $producto->id_producto }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="borrar-boton btn btn-danger">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="paginacion">
    @include('user.productos.layoutproductos.paginacion')
</div>