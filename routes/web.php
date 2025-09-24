<?php

use Illuminate\Support\Facades\Route;
// use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\DetallesComprasController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\VentasController;
use App\Http\Controllers\DetallesVentasController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\DetallesInventarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportesController;

Route::middleware('prevent-back')->group(function () {
    Route::redirect('/', 'login');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::prefix('admin')->group(function () {
        Route::get('usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios.index');
        Route::get('compras', [ComprasController::class, 'index'])->name('admin.compras.index');
        Route::get('detallesCompras', [DetallesComprasController::class, 'index'])->name('admin.detallesCompras.index');
        Route::get('proveedores', [ProveedorController::class, 'index'])->name('admin.proveedores.index');
        Route::get('productos', [ProductoController::class, 'index'])->name('admin.productos.index');
    });

    Route::middleware(['auth', 'role:1'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

        // Mostrar la lista de productos
        Route::get('admin/productos/index', [ProductoController::class, 'index'])->name('admin.productos.index');

        //Generar Reportes Productos
        Route::get('admin/productos/pdf', [ProductoController::class, 'generarPDF'])->name('admin.reportes.productos_pdf');

        // Formulario para crear un nuevo producto
        Route::get('admin/productos/create', [ProductoController::class, 'create'])->name('admin.productos.create');

        // Guardar nuevo producto (form create)
        Route::post('admin/productos/index', [ProductoController::class, 'store'])->name('admin.productos.store');

        // Mostrar el formulario de edición
        Route::get('admin/productos/index/{producto}', [ProductoController::class, 'edit'])->name('admin.productos.edit');

        // Actualizar producto (form edit)  
        Route::get('admin/productos/{producto}', [ProductoController::class, 'show'])->name('admin.productos.show');

        //Actualiza producto
        Route::put('admin/productos/{producto}', [ProductoController::class, 'update'])->name('admin.productos.update');

        // Eliminar producto
        Route::delete('admin/productos/{producto}', [ProductoController::class, 'destroy'])->name('admin.productos.destroy');

        //usuario
        Route::get('admin/usuarios/index', [UsuarioController::class, 'index'])->name('admin.usuarios.index');

        //Formulario para crear un nuevo usuario
        Route::get('admin/usuarios/create', [UsuarioController::class, 'create'])->name('admin.usuarios.create');

        //Guardar nuevo usuario (form create)
        Route::post('admin/usuarios/index', [UsuarioController::class, 'store'])->name('admin.usuarios.store');

        //Mostrar el formulario de edición
        Route::get('admin/usuarios/index/{usuario}', [UsuarioController::class, 'edit'])->name('admin.usuarios.edit');

        //Mostrar usuario
        Route::get('admin/usuarios/{usuario}', [UsuarioController::class, 'show'])->name('admin.usuarios.show');

        //Actualizar usuario (form edit)
        Route::put('admin/usuarios/{usuario}', [UsuarioController::class, 'update'])->name('admin.usuarios.update');

        //Eliminar usuario
        Route::delete('admin/usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy');

        //proveedor
        Route::get('admin/proveedores/index', [ProveedorController::class, 'index'])->name('admin.proveedores.index');

        //Formulario para crear un nuevo proveedor
        Route::get('admin/proveedores/create', [ProveedorController::class, 'create'])->name('admin.proveedores.create');

        //Guardar nuevo proveedor (form create)
        Route::post('admin/proveedores/index', [ProveedorController::class, 'store'])->name('admin.proveedores.store');

        //Mostrar el formulario de edición
        Route::get('admin/proveedores/index/{proveedor}', [ProveedorController::class, 'edit'])->name('admin.proveedores.edit');

        //Mostrar proveedor
        Route::get('admin/proveedores/{proveedor}', [ProveedorController::class, 'show'])->name('admin.proveedores.show');

        //Actualizar proveedor (form edit)
        Route::put('admin/proveedores/{proveedor}', [ProveedorController::class, 'update'])->name('admin.proveedores.update');

        //Eliminar proveedor
        Route::delete('admin/proveedores/{proveedor}', [ProveedorController::class, 'destroy'])->name('admin.proveedores.destroy');

        //compras
        Route::get('admin/compras/index', [ComprasController::class, 'index'])->name('admin.compras.index');

        //Generar Reporte Compras 
        Route::get('admin/compras/pdf', [ComprasController::class, 'generarPDF'])->name('admin.reportes.compras_pdf');


        //Formulario para crear una nueva compras
        Route::get('admin/compras/create', [ComprasController::class, 'create'])->name('admin.compras.create');

        //Guardar nueva compra (form create)
        Route::post('admin/compras/index', [ComprasController::class, 'store'])->name('admin.compras.store');

        //Mostrar el formulario de edición
        Route::get('admin/compras/index/{compra}', [ComprasController::class, 'edit'])->name('admin.compras.edit');

        //Mostrar compras
        Route::get('admin/compras/{compra}', [ComprasController::class, 'show'])->name('admin.compras.show');

        //Actualizar compra (form edit)
        Route::put('admin/compras/{compra}', [ComprasController::class, 'update'])->name('admin.compras.update');

        //Eliminar compra
        Route::delete('admin/compras/{compra}', [ComprasController::class, 'destroy'])->name('admin.compras.destroy');

        // Formulario para crear un nuevo detalle de una compra
        Route::get('admin/compras/{id_compra}/detalles/create', [DetallesComprasController::class, 'create'])
            ->name('admin.detallesCompras.create');

        // Guardar nuevo detalle
        Route::post('admin/compras/{id_compra}/detalles', [DetallesComprasController::class, 'store'])
            ->name('admin.detallesCompras.store');

        // Lista de detalles de una compra
        Route::get('admin/compras/{id_compra}/detalles', [DetallesComprasController::class, 'index'])
            ->name('admin.detallesCompras.index');

        // Mostrar un detalle específico
        Route::get('admin/compras/{detalle}', [DetallesComprasController::class, 'show'])
            ->name('admin.detallesCompras.show');

        // Editar un detalle
        Route::get('admin/compras/detalles/editar/{id_detalle_compra}', [DetallesComprasController::class, 'edit'])
            ->name('admin.detallesCompras.edit');

        // Actualizar un detalle
        Route::put('/admin/detallesCompras/{detalleCompra}', [DetallesComprasController::class, 'update'])
            ->name('admin.detallesCompras.update');


        // Eliminar un detalle
        Route::delete('admin/detallesCompras/{detalle}', [DetallesComprasController::class, 'destroy'])
            ->name('admin.detallesCompras.destroy');

        //clientes
        //mostrar lista de clientes
        Route::get('admin/clientes/index', [ClientesController::class, 'index'])->name('admin.clientes.index');

        // Formulario para crear un nuevo cliente
        Route::get('admin/clientes/create', [ClientesController::class, 'create'])->name('admin.clientes.create');

        // Guardar nuevo producto (form create)
        Route::post('admin/clientes/index', [ClientesController::class, 'store'])->name('admin.clientes.store');

        // Mostrar el formulario de edición
        Route::get('admin/clientes/{cliente}', [ClientesController::class, 'edit'])->name('admin.clientes.edit');

        // Actualizar producto (form edit)  
        Route::get('admin/clientes/{cliente}', [ClientesController::class, 'show'])->name('admin.clientes.show');

        //Actualiza producto
        Route::put('admin/clientes/{cliente}', [ClientesController::class, 'update'])->name('admin.clientes.update');

        // Eliminar producto
        Route::delete('admin/clientes/{cliente}', [ClientesController::class, 'destroy'])->name('admin.clientes.destroy');

        //ventas
        Route::get('admin/ventas/index', [VentasController::class, 'index'])->name('admin.ventas.index');

        //Generar Reporte
        Route::get('admin/ventas/pdf', [VentasController::class, 'generarPDF'])->name('admin.reportes.ventas_pdf');

        //Formulario para crear una nueva compras
        Route::get('admin/ventas/create', [VentasController::class, 'create'])->name('admin.ventas.create');

        //Guardar nueva compra (form create)
        Route::post('admin/ventas/index', [VentasController::class, 'store'])->name('admin.ventas.store');

        //Mostrar el formulario de edición
        Route::get('admin/ventas/index/{venta}', [VentasController::class, 'edit'])->name('admin.ventas.edit');

        //Mostrar compras
        Route::get('admin/ventas/{venta}', [VentasController::class, 'show'])->name('admin.ventas.show');

        //Actualizar compra (form edit)
        Route::put('admin/ventas/{venta}', [VentasController::class, 'update'])->name('admin.ventas.update');

        //Eliminar compra
        Route::delete('admin/ventas/{venta}', [VentasController::class, 'destroy'])->name('admin.ventas.destroy');

        // Detalles de venta
        Route::get('admin/ventas/{id_venta}/detalles', [DetallesVentasController::class, 'index'])
            ->name('admin.detallesVentas.index');

        // Formulario para crear un nuevo detalle de una venta
        Route::get('admin/ventas/{id_venta}/detalles/create', [DetallesVentasController::class, 'create'])
            ->name('admin.detallesVentas.create');

        // Guardar nuevo detalle
        Route::post('admin/ventas/{id_venta}/detalles', [DetallesVentasController::class, 'store'])
            ->name('admin.detallesVentas.store');

        // Mostrar un detalle específico
        Route::get('admin/ventas/{id_venta}/detalles/{id_detalle_venta}', [DetallesVentasController::class, 'show'])
            ->name('admin.detallesVentas.show');

        // Editar un detalle
        Route::get('admin/ventas/detalles/editar/{id_detalle_venta}', [DetallesVentasController::class, 'edit'])
            ->name('admin.detallesVentas.edit');

        // Actualizar un detalle
        Route::put('/admin/detallesVentas/{detalleVenta}', [DetallesVentasController::class, 'update'])
            ->name('admin.detallesVentas.update');


        // Eliminar un detalle
        Route::delete('admin/ventas/detalles/{id_detalle_venta}', [DetallesVentasController::class, 'destroy'])
            ->name('admin.detallesVentas.destroy');

        //inventario
        Route::get('admin/inventario/index', [InventarioController::class, 'index'])->name('admin.inventario.index');
        Route::get('admin/inventario/pdf', [InventarioController::class, 'generarPDF'])->name('admin.reportes.inventario_pdf');
        Route::get('admin/inventario/{id_producto}/detalles', [DetallesInventarioController::class, 'index'])->name('admin.detallesInventario.index');
    });

    // 🔒 Rutas para Usuario corriente (rol 2)
    Route::middleware(['auth', 'role:2'])->group(function () {
        Route::get('user/dashboard', [DashboardController::class, 'index'])->name('user.dashboard');
        Route::get('user/productos/index', [ProductoController::class, 'index'])->name('user.productos.index');
        Route::get('user/proveedores/index', [ProveedorController::class, 'index'])->name('user.proveedores.index');
        Route::get('user/inventario/index', [InventarioController::class, 'index'])->name('user.inventario.index');
        Route::get('user/ventas/index', [VentasController::class, 'index'])->name('user.ventas.index');
        Route::get('user/compras/index', [ComprasController::class, 'index'])->name('user.compras.index');
        Route::get('user/usuarios/index', [UsuarioController::class, 'index'])->name('user.usuarios.index');
        Route::get('user/clientes/index', [ClientesController::class, 'index'])->name('user.clientes.index');
        Route::get('user/ventas/pdf', [VentasController::class, 'generarPDF'])->name('user.reportes.ventas_pdf');
        Route::get('user/productos/pdf', [ProductoController::class, 'generarPDF'])->name('user.reportes.productos_pdf');
        Route::get('user/inventario/pdf', [InventarioController::class, 'generarPDF'])->name('user.reportes.inventario_pdf');
        Route::get('user/compras/pdf', [ComprasController::class, 'generarPDF'])->name('user.reportes.compras_pdf');
        Route::get('user/ventas/pdf', [VentasController::class, 'generarPDF'])->name('user.reportes.ventas_pdf');
        Route::get('user/ventas/{id_venta}/detalles', [DetallesVentasController::class, 'index'])
            ->name('user.detallesVentas.index');
        Route::get('user/compras/{id_compra}/detalles', [DetallesComprasController::class, 'index'])
            ->name('user.detallesCompras.index');
        Route::get('user/inventario/{id_producto}/detalles', [DetallesInventarioController::class, 'index'])->name('user.detallesInventario.index');
    });


    //cerrar sesion
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
