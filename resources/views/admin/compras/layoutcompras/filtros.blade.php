<form id="filtro-form-compras" method="GET">
    @csrf
    <div class="filtros">
        <select name="PorPagina" id="entries" class="form-control">
            <option disabled selected>Selecciona datos a mostrar</option>
            <option value="15" {{ request('PorPagina') == 15 ? 'selected' : '' }}>15</option>
            <option value="20" {{ request('PorPagina') == 20 ? 'selected' : '' }}>20</option>
            <option value="25" {{ request('PorPagina') == 25 ? 'selected' : '' }}>25</option>
            <option value="30" {{ request('PorPagina') == 30 ? 'selected' : '' }}>30</option>
        </select>
        <label class="inputdate" for="fechaInicio">Compra desde:</label>
        <input type="date" id="fechaInicio" name="fechaInicio" value="{{ request('fechaInicio') }}"
            class="form-control">
        <label class="inputdate" for="fechaFin">hasta:</label>
        <input type="date" id="fechaFin" name="fechaFin" value="{{ request('fechaFin') }}" class="form-control">
        <input class="form-control" type="text" id="buscarProveedor" placeholder="Buscar proveedor...">
        {{-- <ul id="listaProveedores">
            @foreach ($proveedores as $proveedor)
                <li data-id="{{ $proveedor->id_proveedor }}">
                    {{ $proveedor->nombre_proveedor }}
                </li>
            @endforeach
        </ul> --}}

        <input type="hidden" name="id_proveedor" id="idProveedorSeleccionado">
        <button type="button" id="limpiar-filtros-compras" class="form-control"><i class="fa-solid fa-eraser"
                style="color: #ffffff;"></i></button>
    </div>
</form>
<script src="{{ asset('js/compras/filtrar.js') }}"></script>
