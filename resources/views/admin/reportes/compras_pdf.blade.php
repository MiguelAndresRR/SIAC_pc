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
    </style>
</head>

<body>
    <h1>{{ $titulo }}</h1>
    <p>Fecha: {{ $fecha }}</p>
    <img src="{{ public_path('img/fcb3d0d432b3cf67e3ea03bcc96b5223.jpg') }}" alt="Logo" width="50px" height="50px">
    @foreach ($compras as $compra)
        <h3>Compra # {{ $compra->id_compra }}</h3>
        <p>Comprador: {{ $compra->usuario->nombre_usuario }}
        </p>
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
                @foreach ($compra->detalleCompra as $detalle)
                    <tr>
                        <td>{{ $detalle->id_detalle_compra}}</td>
                        <td>{{ $detalle->producto->nombre_producto }}</td>
                        <td>{{ $detalle->cantidad_producto }}</td>
                        <td>{{ $detalle->precio_unitario }}</td>
                        <td>{{ $detalle->subtotal_compra }}</td>
                        <td>{{ $detalle->fecha_vencimiento ? \Carbon\Carbon::parse($detalles->fecha_vencimiento)->format('d/m/Y') : 'sin fecha' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>

</html>
