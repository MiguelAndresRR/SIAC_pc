<?php

namespace App\Http\Controllers;

use App\Models\productos\Producto;
use App\Models\ventas\DetalleVenta;
use App\Models\compras\Compra;
use App\Models\inventario\Inventario;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ventas totales
        $ventasTotales = DetalleVenta::sum('cantidad_venta');

        // Ganancias totales
        $gananciasTotales = DetalleVenta::sum('subtotal_venta');

        // Productos más vendidos (top 5)
        $productosMasVendidos = Producto::leftJoin('detalle_venta', 'producto.id_producto', '=', 'detalle_venta.id_producto')
            ->select('producto.nombre_producto', DB::raw('COALESCE(SUM(detalle_venta.cantidad_venta), 0) as total'))
            ->groupBy('producto.id_producto', 'producto.nombre_producto')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        // Productos menos vendidos (top 5)
        $productosMenosVendidos = Producto::leftJoin('detalle_venta', 'producto.id_producto', '=', 'detalle_venta.id_producto')
            ->select('producto.nombre_producto', DB::raw('COALESCE(SUM(detalle_venta.cantidad_venta), 0) as total'))
            ->groupBy('producto.id_producto', 'producto.nombre_producto')
            ->orderBy('total', 'asc')
            ->limit(5)
            ->get();



        $productosSinStock = Inventario::where('stock_total', 0)
            ->join('producto', 'inventario.id_producto', '=', 'producto.id_producto')
            ->pluck('producto.nombre_producto');

        $productosPocoStock = Inventario::where('stock_total', '>=', 1)
            ->where('stock_total', '<=', 15)
            ->join('producto', 'inventario.id_producto', '=', 'producto.id_producto')
            ->pluck('producto.nombre_producto');

        return view('admin.dashboard', [
            'ventasTotales' => $ventasTotales,
            'gananciasTotales' => $gananciasTotales,
            'productosMasVendidos' => $productosMasVendidos,
            'productosMenosVendidos' => $productosMenosVendidos,
            'productosSinStock' => $productosSinStock,
            'productosPocoStock' => $productosPocoStock
        ]);
    }
}
