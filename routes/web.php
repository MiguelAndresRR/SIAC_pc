<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ComprasController;
use App\Http\Controllers\DetallesComprasController;

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

    Route::middleware('auth')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
        Route::get('/user/dashboard', function () {
            return view('user.dashboard');
        })->name('user.dashboard');
        // Mostrar la lista de productos
        Route::get('admin/productos/index', [ProductoController::class, 'index'])->name('admin.productos.index');

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


        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });
});
