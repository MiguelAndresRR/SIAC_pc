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

        /* Encabezado en dos columnas */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-left {
            max-width: 70%;
        }

        img {
            width: 120px;
            /* ajusta el tamaño aquí */
            height: auto;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="header-left">
            <h1>{{ $titulo }}</h1>
            <img src="{{ public_path('img/logoSemilleros.jpg') }}" alt="Logo">
        </div>
    </div>
    @foreach ($inventario as $datos)
        <h3>Código: {{ $datos->producto->id_producto }}</h3>
        <p>Producto: {{ $datos->producto->nombre_producto }}</p>
        <p>Stock total: {{ $datos->stock_total }}</p>

        <table>
            <thead>
                <tr>
                    <th>Lote</th>
                    <th>Stock del Lote</th>
                    <th>Fecha Vencimiento</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $lotes = $detalles->where('detalleCompra.id_producto', $datos->id_producto);
                @endphp
                @forelse($lotes as $detalle)
                    <tr>
                        <td>{{ $detalle->id_detalle_compra ?? 'sin lotes' }}</td>
                        <td>{{ $detalle->stock_lote ?? 'sin stock' }}</td>
                        <td>{{ $detalle->detalleCompra->fecha_vencimiento  ? \Carbon\Carbon::parse($detalle->detalleCompra->fecha_vencimiento)->format('d/m/Y') : 'sin fecha de vencimiento'  }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align:center;"><em>No se registraron Lotes</em></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach
</body>

</html>
