<div class="container-clientes-class">
    <table class="tableFixHead">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Documento</th>
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Correo</th>

                <th>
                    <button type="submit" class="btn" id='crear-modal-clientes'>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </th>

            </tr>
        </thead>
        <tbody id="container-clientes-table">
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nombre_cliente }}</td>
                    <td>{{ $cliente->apellido_cliente}}</td>
                    <td>{{ $cliente->documento_cliente}}</td>
                    <td>{{ $cliente->telefono_cliente}}</td>
                    <td>{{ $cliente->direccion_cliente}}</td>
                    <td>{{ $cliente->correo_cliente}}</td>
                    <td id="botones">
                        <button type="button" class="btn-ver clientes-btn-ver" id="btn-ver-clientes" data-id_cliente="{{$cliente->id_cliente}}">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" class="btn-editar" id="btn-editar-cliente" data-id_cliente="{{$cliente->id_cliente}}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="borrar-boton btn btn-danger"
                            data-id_cliente="{{ $cliente->id_cliente}}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        @if ($cliente->id_cliente)
                            <form id="formEliminar{{ $cliente->id_cliente }}" method="POST"
                                action="{{ route('admin.clientes.destroy',$cliente->id_cliente)}}"
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
    @include('admin.clientes.layoutclientes.paginacion')
</div>
<script src="{{ asset('js/clientes/borrar.js') }}"></script>
