<form id="filtro-form-detallesCompras" method="GET">
    @csrf
    <div class="filtros">
        <select name="PorPagina" id="entries" class="form-control">
            <option disabled selected>Selecciona datos a mostrar</option>
            <option value="15" {{ request('PorPagina') == 15 ? 'selected' : '' }}>15</option>
            <option value="20" {{ request('PorPagina') == 20 ? 'selected' : '' }}>20</option>
            <option value="25" {{ request('PorPagina') == 25 ? 'selected' : '' }}>25</option>
            <option value="30" {{ request('PorPagina') == 30 ? 'selected' : '' }}>30</option>
        </select>
        <input type="text" id="producto" name="producto" class="form-control"
            value="{{ request('producto') }}" placeholder="Buscar producto...">
        <button type="button" id="limpiar-filtros-detallesCompras" class="form-control"><i class="fa-solid fa-eraser"
                style="color: #ffffff;"></i></button>
    </div>
</form>
<script src="{{ asset('js/detallesCompras/filtrar.js') }}"></script>
