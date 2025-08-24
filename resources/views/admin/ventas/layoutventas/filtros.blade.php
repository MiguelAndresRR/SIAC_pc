<form id="filtro-form-compras" method="GET">
    @csrf
    <div class="filtros">
        <label class="inputdate" for="fechaInicio">Desde:</label>
        <input type="date" id="fechaInicio" name="fechaInicio" value="{{ request('fechaInicio') }}" class="form-control">
        <label class="inputdate" for="fechaFin">hasta:</label>
        <input type="date" id="fechaFin" name="fechaFin" value="{{ request('fechaFin') }}" class="form-control">
        <select name="proveedorSelect" id="proveedorSelect" class="form-control">
            <option disabled selected>Proveedores</option>
            @foreach ($proveedores as $proveedor)
                <option value="{{ $proveedor->nombre_proveedor }}">{{ $proveedor->nombre_proveedor }}</option>
            @endforeach
        </select>
        <select name="PorPagina" id="entries" class="form-control">
            <option disabled selected>Selecciona datos a mostrar</option>
            <option value="10" {{ request('PorPagina') == 10 ? 'selected' : '' }}>10</option>
            <option value="15" {{ request('PorPagina') == 15 ? 'selected' : '' }}>15</option>
            <option value="20" {{ request('PorPagina') == 20 ? 'selected' : '' }}>20</option>
            <option value="25" {{ request('PorPagina') == 25 ? 'selected' : '' }}>25</option>
            <option value="30" {{ request('PorPagina') == 30 ? 'selected' : '' }}>30</option>
        </select>
        <input type="hidden" name="id_proveedor" id="idProveedorSeleccionado">
        <button type="button" id="limpiar-filtros-compras" class="form-control"><i class="fa-solid fa-eraser"
                style="color: #ffffff;"></i></button>
    </div>
</form>
<script src="{{ asset('js/compras/filtrar.js') }}"></script>
<script>
    let proveedorSelectTS;

    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("filtro-form-compras");
        const limpiarBtn = document.getElementById("limpiar-filtros-compras");

        // Inicializar Tom Select y guardar la instancia
        proveedorSelectTS = new TomSelect("#proveedorSelect", {
            placeholder: "Buscar proveedor...",
            plugins: ["remove_button"],
            maxItems: 1,
            allowEmptyOption: true,
            create: false,
            dropdownClass: "ts-dropdown",
            controlInput: "<input>",
        });

        // Evento para limpiar filtros
        if (limpiarBtn) {
            limpiarBtn.addEventListener("click", function(e) {
                e.preventDefault();
                e.stopPropagation();

                form.reset();
                if (proveedorSelectTS) {
                    proveedorSelectTS.clear();
                }

                filtro();
            });
        }
    });
</script>
