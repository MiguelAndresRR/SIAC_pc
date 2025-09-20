<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <div class="container">
        <h1>Bienvenido, {{ Auth::user()->user }} ({{ Auth::user()->id_rol == 1 ? 'Administrador' : 'Usuario' }})</h1>
        <header class="header">
            <nav class="nav">
                <input type="text" class="nav-search" placeholder="Buscar...">
                <div class="nav-user">
                    <img src="{{ asset('img/user.png') }}" alt="User" class="nav-user-img">
                    <span class="nav-user-name">{{ Auth::user()->user }}</span>
                </div>
                <ul class="nav-menu">
                    <li class="nav-menu-item"><a href="#" class="nav-menu-link">Inicio</a></li>
                    <li class="nav-menu-item"><a href="#" class="nav-menu-link">Usuarios</a></li>
                    <li class="nav-menu-item"><a href="#" class="nav-menu-link">Ventas</a></li>
                    <li class="nav-menu-item"><a href="#" class="nav-menu-link">Compras</a></li>
                    <li class="nav-menu-item"><a href="#" class="nav-menu-link">Reportes</a></li>
                    <li class="nav-menu-item"><a href="#" class="nav-menu-link">Compras</a></li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    <li class="nav-menu-item">
                        <a href="#" class="nav-menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </nav>
        </header>
    </div>
</body>

</html>
