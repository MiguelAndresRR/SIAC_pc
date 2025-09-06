<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clientes</title>
    <meta charset="UTF-8">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://kit.fontawesome.com/171f3dc321.js" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/clientes/clientes.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/clientes/editar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/clientes/tabla.css') }}">
    <link rel="stylesheet" href="{{ asset('css/clientes/paginacion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/clientes/mostrar.css') }}">
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
    <div class="content-clientes">
        <div class="header">
            <h1><i class="fa-solid fa-hand-holding-heart"></i>Clientes</h1>
        </div>
        @include('admin.clientes.layoutclientes.filtros')
        <div id="tabla-clientes">
            @include('admin.clientes.layoutclientes.tablaclientes')
        </div>
    </div>
    @include('admin.clientes.modal.edit')
    @include('admin.clientes.modal.mostrar')
    @include('admin.clientes.modal.create')
    <script src="{{ asset('js/clientes/crear.js') }}"></script>
    <script src="{{ asset('js/clientes/editar.js') }}"></script>
    <script src="{{ asset('js/clientes/showboton.js') }}"></script>
    <script src="{{ asset('js/clientes/borrar.js') }}"></script>
    <script src="{{ asset('js/clientes/filtrar.js') }}"></script>
    <script src="{{ asset('js/clientes/validarFormularios.js') }}"></script>
    <script src="{{ asset('js/clientes/validarFormeEdit.js')}}"></script>
</body>
</html>
