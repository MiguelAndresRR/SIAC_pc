<div class="grid-container">
    <div class="grid-card" id="sin-stock">
        <h4>Sin Stock</h4>
        <div>
            <ul>
                @foreach ($productosSinStock as $producto)
                    <li>{{ $producto }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="grid-card" id="poco-stock">
        <h4>Poco Stock</h4>
        <div>
            <ul>
                @foreach ($productosPocoStock as $producto)
                    <li>{{ $producto }}</li>
                @endforeach
            </ul>
        </div>
    </div>

</div>
