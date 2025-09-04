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
            <p>Fecha: {{ $fecha }}</p>
            <p>Desde: {{ $desde }} Hasta: {{ $hasta }}</p>
        </div>
        <div class="header-right">

        </div>
    </div>

    @foreach ($compras as $compra)
        <h3>Compra # {{ $compra->id_compra }}</h3>
        <p>Comprador: {{ $compra->usuario->nombre_usuario }}</p>
        <p>Fecha: {{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y') }}</p>
        <p>Proveedor: {{ $compra->proveedor->nombre_proveedor }}</p>

        <table>
            <thead>
                <tr>
                    <th>Lote</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unidad</th>
                    <th>Total</th>
                    <th>Fecha Vencimiento</th>
                </tr>
            </thead>
            <tbody>
                @forelse($compra->detalleCompra as $detalle)
                    <tr>
                        <td>{{ $detalle->id_detalle_compra ?? 'sin lotes' }}</td>
                        <td>{{ $detalle->producto->nombre_producto ?? 'sin productos' }}</td>
                        <td>{{ $detalle->cantidad_producto ?? 'sin cantidades' }}</td>
                        <td>${{ $detalle->precio_unitario ?? 'sin precios unitarios' }}</td>
                        <td>${{ $detalle->subtotal_compra ?? 'sin subtotales' }}</td>
                        <td>
                            {{ $detalle->fecha_vencimiento ? \Carbon\Carbon::parse($detalle->fecha_vencimiento)->format('d/m/Y') : 'sin fecha de vencimiento' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center;"><em>No se registraron productos</em></td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

    <h2>Resumen General</h2>
    <p>El total de las compras seleccionadas es: ${{ $totalGeneral }}</p>
</body>
</html>
