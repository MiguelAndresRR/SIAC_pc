<form id="filtro-form-clientes" class="filtros" method="GET">
    @csrf
    <div class="filtros">

        <input type="text" id="buscar_nombre_cliente" name="buscar_nombre_cliente" class="form-control"
            placeholder="Buscar nombre cliente">
        <input type="text" id="buscar_documento_cliente" name="buscar_documento_cliente" class="form-control"
            placeholder="Buscar documento...">
        <select name="entries" id="entries" class="form-control">
            <option disabled selected>Selecciona datos a mostrar</option>
            <option value="15" {{ request('PorPagina') == 15 ? 'selected' : '' }}>15</option>
            <option value="20" {{ request('PorPagina') == 20 ? 'selected' : '' }}>20</option>
            <option value="25" {{ request('PorPagina') == 25 ? 'selected' : '' }}>25</option>
            <option value="30" {{ request('PorPagina') == 30 ? 'selected' : '' }}>30</option>
        </select>
        <button type="button" id="limpiar-filtros-clientes" class="form-control"><i class="fa-solid fa-eraser"
                style="color: #ffffff;"></i></button>
    </div>
</form>
