<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inventario\Inventario;
use App\Models\productos\Producto;
use App\Models\compras\Compra;
use App\Models\compras\DetalleCompra;
use App\Models\inventario\DetalleInventario;
use App\Models\ventas\DetalleVenta;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $productos = Producto::pluck('id_producto');

        foreach ($productos as $idProducto) {
            $stock_total = DetalleInventario::join('detalle_compra', 'detalle_inventario.id_detalle_compra', '=', 'detalle_compra.id_detalle_compra')
                ->where('detalle_compra.id_producto', $idProducto)
                ->sum('detalle_inventario.stock_lote');
            Inventario::updateOrCreate(
                ['id_producto' => $idProducto],
                ['stock_total' => $stock_total]
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
