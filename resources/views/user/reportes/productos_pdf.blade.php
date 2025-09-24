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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
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
            <p>Categoria: {{ $categoria }}</p>
            <p>Unidad de Medida: {{ $unidad }}</p>
        </div>
    </div>
    @foreach ($productos as $producto)
        <h3>Codigo de producto: #{{ $producto->id_producto }}</h3>
        <p>Nombre del producto: {{ $producto->nombre_producto }}</p>
        <p>Precio del producto: ${{ $producto->precio_producto }}</p>
        <p>Categoria: {{ $producto->categoria->categoria }}</p>
        <p>Unidad Medida: {{ $producto->unidad->unidad_peso }}</p>
        <hr>
    @endforeach
</body>

</html>
