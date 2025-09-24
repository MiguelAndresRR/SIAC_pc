<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\inventario\Inventario;
use App\Models\productos\Producto;
use App\Models\compras\Compra;
use App\Models\compras\DetalleCompra;
use App\Models\inventario\DetalleInventario;
use App\Models\ventas\DetalleVenta;


class InventarioController extends Controller
{
    //Nos trae todos los productos creados, para registrarlos en la tabla inventario. Ademas realizamos un stock total con todos los detalles de inventario.
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
        $user = Auth::user();
        if ($user->id_rol == 1) {
            if ($request->ajax()) {
                return view('admin.inventario.layoutinventario.tablainventario', compact('inventarioProductos'))->render();
            }

            return view('admin.inventario.index', compact('inventarioProductos'));
        } elseif ($user->id_rol == 2) {
            if ($request->ajax()) {
                return view('user.inventario.layoutinventario.tablainventario', compact('inventarioProductos'))->render();
            }

            return view('user.inventario.index', compact('inventarioProductos'));
        }
    }
    //Podemos generar un PDF con todos los productos, del inventario y un registro de los lotes de cada inventario.
    public function generarPDF()
    {
        $inventario = Inventario::with('producto')->get();

        $detalles = DetalleInventario::with(['detalleCompra.producto'])
            ->where('stock_lote', '>', 0)
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reportes.inventario_pdf', [
            'titulo' => 'Reportes de Inventario',
            'inventario' => $inventario,
            'detalles' => $detalles
        ]);

        return $pdf->download('reporte_inventario.pdf');
    }
}
