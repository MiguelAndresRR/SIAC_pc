<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $titulo }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        img {
            width: 120px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-left">
            <h1>{{ $titulo }}</h1>
            <img src="{{ public_path('img/logoSemilleros.jpg') }}" alt="Logo">
            <hr>
            <p>Fecha: {{ $fecha }}</p>
            <p>Desde: {{ $desde }} Hasta: {{ $hasta }}</p>
        </div>
        <div class="header-right">

        </div>
    </div>

    @foreach ($ventas as $venta)
        <h3>Venta # {{ $venta->id_venta }}</h3>
        <p>Vendedor: {{ $venta->usuario->nombre_usuario }}
        </p>
        <p>Cliente: {{ $venta->cliente->nombre_cliente }} {{ $venta->cliente->apellido_cliente }}</p>
        <p>Fecha: {{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</p>
        <p>Total Precio: {{ $venta->total_venta }}</p>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>cantidad_venta</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($venta->detalleVenta as $detalle)
                    <tr>
                        <td>{{ $detalle->producto->nombre_producto }}</td>
                        <td>{{ $detalle->cantidad_venta }}</td>
                        <td>{{ $detalle->precio_unitario_venta }}</td>
                        <td>{{ $detalle->subtotal_venta }}</td>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;"><em>No se registraron productos</em></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <br>
        <hr>
    @endforeach
    <h2>Resumen General</h2>
    <p>El total de las ventas seleccionadas es: ${{ $totalGeneral }}</p>
</body>

</html>
