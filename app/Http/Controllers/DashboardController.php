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

        // Productos más vendidos (top 6)
        $productosMasVendidos = DetalleVenta::join('producto', 'detalle_venta.id_producto', '=', 'producto.id_producto')
            ->select('producto.nombre_producto', DB::raw('SUM(detalle_venta.cantidad_venta) as total'))
            ->groupBy('producto.nombre_producto')
            ->orderByDesc('total')
            ->limit(6)
            ->get();

        // Productos menos vendidos (top 6)
        $productosMenosVendidos = DetalleVenta::join('producto', 'detalle_venta.id_producto', '=', 'producto.id_producto')
            ->select('producto.nombre_producto', DB::raw('SUM(detalle_venta.cantidad_venta) as total'))
            ->groupBy('producto.nombre_producto')
            ->orderBy('total')
            ->limit(6)
            ->get();

        // Productos sin stock (0)
        $productosSinStock = Inventario::where('stock_total', '==', 0)->count();

        // Productos con poco stock (≤5)
        $productosPocoStock = Inventario::where('stock_total', '<=', 5)->count();

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
