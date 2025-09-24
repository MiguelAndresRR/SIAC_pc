<div class="container-proveedores-class">
    <table class="tableFixHead">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Telefono</th>
                <th>NIT</th>
                <th>Direccion</th>
                <th>Correo</th>
                <th>
                    <button type="submit" class="btn" id='crear-modal-proveedores'>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </th>

            </tr>
        </thead>
        <tbody id="container-proveedores-table">
            @foreach ($proveedores as $proveedor)
                <tr>

                    <td>{{ $proveedor->nombre_proveedor }}</td>
                    <td>{{ $proveedor->telefono_proveedor}}</td>
                    <td>{{ $proveedor->nit_proveedor}}</td>
                    <td>{{ $proveedor->direccion_proveedor}}</td>
                    <td>{{ $proveedor->correo_proveedor}}</td>
                    <td id="botones">
                        <button type="button" class="btn-ver proveedores-btn-ver" id="btn-ver-proveedores" data-id_proveedor="{{ $proveedor->id_proveedor}}">
                            <i class="fa-solid fa-eye"></i>
                        </button>
                        <button type="button" class="btn-editar" id="btn-editar-proveedores" data-id_proveedor="{{$proveedor->id_proveedor}}">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                        <button type="button" class="borrar-boton btn btn-danger"
                            data-id_proveedor="{{ $proveedor->id_proveedor}}">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        @if ($proveedor->id_proveedor)
                            <form id="formEliminar{{ $proveedor->id_proveedor }}" method="POST"
                                action="{{ route('admin.proveedores.destroy',$proveedor->id_proveedor)}}"
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
    @include('user.proveedores.layoutproveedores.paginacion')
</div>
