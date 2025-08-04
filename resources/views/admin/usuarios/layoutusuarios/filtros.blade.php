<form id="filtro-form-usuarios" class="filtros" method="GET">
    @csrf
    <div class="filtros">
        <select name="rol" id="rol" class="form-control">
            <option value="">Todos los Roles</option>
            @foreach ($roles as $rol)
                <option value="{{ $rol->nombre_rol}}">{{ $rol->nombre_rol}}</option>
            @endforeach
        </select>
        <select name="entries" id="entries" class="form-control">
            <option disabled selected>Selecciona datos a mostrar</option>
            <option value="15" {{ request('PorPagina') == 15 ? 'selected' : '' }}>15</option>
            <option value="20" {{ request('PorPagina') == 20 ? 'selected' : '' }}>20</option>
            <option value="25" {{ request('PorPagina') == 25 ? 'selected' : '' }}>25</option>
            <option value="30" {{ request('PorPagina') == 30 ? 'selected' : '' }}>30</option>
        </select>
        <input type="text" id="nombre_usuario-buscar" name="buscar_nombre" class="form-control" placeholder="Buscar nombre o apellido...">
        <input type="text" id="documento_usuario-buscar" name="buscar_documento" class="form-control" placeholder="Buscar documento...">
        <button type="button" id="limpiar-filtros-usuarios" class="form-control"><i class="fa-solid fa-eraser"
                style="color: #ffffff;"></i></button>
    </div>
</form>
