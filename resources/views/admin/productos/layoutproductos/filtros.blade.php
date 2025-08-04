<form id="filtro-form-productos" class="filtros" method="GET">
    @csrf
    <div class="filtros">
        <select name="categoria" id="filtro-categoria" class="form-control">
            <option value="">Todas las categorías</option>
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id_categoria_producto }}">{{ $categoria->categoria }}</option>
            @endforeach
        </select>
        <select name="unidad" id="filtro-unidad" class="form-control">
            <option value="">Todas las unidades de medida</option>
            @foreach ($unidades as $unidad)
                <option value="{{ $unidad->id_unidad_peso_producto }}">{{ $unidad->unidad_peso }}</option>
            @endforeach
        </select>
        <select id="entries" class="form-control" {{ $productos->appends(request()->query())->links() }}>
            <option disabled selected>Selecciona datos a mostrar</option>
            <option value="10" {{ request('PorPagina') == 10 ? 'selected' : '' }}>10</option>
            <option value="15" {{ request('PorPagina') == 15 ? 'selected' : '' }}>15</option>
            <option value="20" {{ request('PorPagina') == 20 ? 'selected' : '' }}>20</option>
        </select>
        <input type="text" id="buscarProducto" name="buscar_productos" class="form-control" placeholder="Buscar producto...">
        <button type="button" id="limpiar-filtros-productos" class="form-control"><i class="fa-solid fa-eraser"></i>
    </div>
</form>
