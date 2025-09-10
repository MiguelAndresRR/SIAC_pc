<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inventario</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://kit.fontawesome.com/171f3dc321.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/inventario/inventario.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/inventario/editar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inventario/tabla.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inventario/paginacion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inventario/mostrar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/inventario/inputSearch.css') }}">



    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Noto+Sans+JP:wght@100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body>
    <div class="container">
        @if (session('message'))
            <script>
                Swal.fire({
                    title: {!! session('message')['type'] === 'error' ? json_encode('Error') : json_encode('Éxito') !!},
                    text: @json(session('message')['text']),
                    icon: @json(session('message')['type']),
                    confirmButtonText: 'Aceptar',
                    customClass: {
                        confirmButton: 'btn-confirmar'
                    },
                    buttonsStyling: false
                });
            </script>
        @endif
    </div>
    @include('admin.layout.sidebar')
    <div class="content-inventario">
        <div class="header">
            <h1><i class="fa-solid fa-bag-shopping"></i>Inventario</h1>
            <a onclick="window.location.href='{{ route('admin.reportes.inventario_pdf') }}'" class="pdfGenerar">
                <i class="fa fa-file-pdf"></i> Generar PDF
            </a>
        </div>
        @include('admin.inventario.layoutinventario.filtros')
        <div id="tabla-inventario">
            @include('admin.inventario.layoutinventario.tablainventario')
        </div>
    </div>
    <script src="{{ asset('js/inventario/verDetalles.js') }}"></script>
</body>
</html>
