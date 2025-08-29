<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inventario\Inventario;
use App\Models\productos\Producto;
use App\Models\compras\Compra;
use App\Models\compras\DetalleCompra;
use App\Models\ventas\DetalleVenta;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $productos = Producto::pluck('id_producto');

        foreach ($productos as $idProducto) {
            Inventario::firstOrCreate(
                ['id_producto' => $idProducto],
                ['stock_total' => 0]
            );
        }
        $porPagina = $request->input('PorPagina', 10);
        $inventarioProductos = Inventario::with('producto')->paginate($porPagina);
        if ($request->ajax()) {
            return view('admin.inventario.layoutinventario.tablainventario', compact('inventarioProductos'))->render();
        }

        return view('admin.inventario.index', compact('inventarioProductos'));
    }
}
