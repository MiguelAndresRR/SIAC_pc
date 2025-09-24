{{-- Nos muestra una tarjeta sobre la ganancia totales y ventas totales --}}
<div class="grid-container">
    <div class="grid-card" id="ganancias">
        <h4>Ganancias</h4>
        <p>${{ number_format($gananciasTotales, 0) }}</p>
    </div>
    <div class="grid-card" id="ventas-compras">
        <div>
            <h4>Ventas Totales</h4>
            <p>{{ $ventasTotales }}</p>
        </div>
    </div>
</div>
