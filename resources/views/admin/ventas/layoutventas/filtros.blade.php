<form id="filtro-form-ventas" method="GET">
    @csrf
    <div class="filtros">
        <label class="inputdate" for="fechaInicio">Desde:</label>
        <input type="date" id="fechaInicio" name="fechaInicio" value="{{ request('fechaInicio') }}" class="form-control">
        <label class="inputdate" for="fechaFin">hasta:</label>
        <input type="date" id="fechaFin" name="fechaFin" value="{{ request('fechaFin') }}" class="form-control">
        <select name="clienteSelect" id="clienteSelect">
            <option disabled selected>Clientes</option>
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id_cliente }}">
                    {{ $cliente->nombre_cliente }} {{ $cliente->apellido_cliente }} -
                    {{ $cliente->documento_cliente }}
                </option>
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
        <input type="hidden" name="id_cliente" id="idClienteSeleccionado">
        <button type="button" id="limpiar-filtros-ventas" class="form-control"><i class="fa-solid fa-eraser"
                style="color: #ffffff;"></i></button>
    </div>
</form>
<script src="{{ asset('js/ventas/filtrar.js') }}"></script>
<script>
    let clienteSelectTS;

    document.addEventListener("DOMContentLoaded", function() {
        const form = document.getElementById("filtro-form-ventas");
        const limpiarBtn = document.getElementById("limpiar-filtros-ventas");

        // Inicializar Tom Select y guardar la instancia
        clienteSelectTS = new TomSelect("#clienteSelect", {
            placeholder: "Buscar cliente...",
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
                if (clienteSelectTS) {
                    clienteSelectTS.clear();
                }

                filtro();
            });
        }
    });
</script>
