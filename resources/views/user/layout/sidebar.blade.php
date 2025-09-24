        <div class="sidebar collapsed" id="sidebar">
            <a onclick="window.location.href='{{ route('user.dashboard') }}'" class="nav_link">
                <i class="fa-solid fa-chart-line"></i>
                <span class="span-subtittle">Dashboard</span>
            </a>
            <a onclick="window.location.href='{{ route('user.productos.index') }}'" class="nav_link">
                <i class="fa-solid fa-box"></i>
                <span class="span-subtittle">Productos</span>
            </a>
            <a onclick="window.location.href='{{ route('user.proveedores.index') }}'" class="nav_link">
                <i class="fa-solid fa-truck"></i>
                <span class="span-subtittle">Proveedores</span>
            </a>
            <a onclick="window.location.href='{{ route('user.ventas.index') }}'" class="nav_link">
                <i class="fa-solid fa-receipt"></i>
                <span class="span-subtittle">Ventas</span>
            </a>
            <a onclick="window.location.href='{{ route('user.inventario.index') }}'" class="nav_link">
                <i class="fa-solid fa-cubes-stacked"></i>
                <span class="span-subtittle">Inventario</span>
            </a>
            <a onclick="window.location.href='{{ route('user.compras.index') }}'" class="nav_link">
                <i class="fa-solid fa-bag-shopping"></i>
                <span class="span-subtittle">Compras</span>
            </a>
            <a onclick="window.location.href='{{ route('user.usuarios.index') }}'" class="nav_link">
                <i class="fa-solid fa-users"></i>
                <span class="span-subtittle">Usuarios</span>
            </a>
            <a onclick="window.location.href='{{ route('user.clientes.index') }}'" class="nav_link">
                <i class="fa-solid fa-hand-holding-heart"></i>
                <span class="span-subtittle">Clientes</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a href="#" id="logout" class="nav_link"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="span-subtittle">Cerrar Sesión</span>
            </a>
            <span class="usuarioLogin">{{ Auth::user()->user }} ({{ Auth::user()->rol->nombre_rol }})</span>

        </div>
        <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>
