<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inventario\DetalleInventario;
use App\Models\compras\DetalleCompra;
use App\Models\inventario\Inventario;
use App\Models\productos\Producto;

class DetallesInventarioController extends Controller
{
    public function index(Request $request, $id_producto)
    {
        
        $inventario = Inventario::where('id_producto', $id_producto)->first();
        if ($inventario) {
            $detallesCompra = DetalleCompra::where('id_producto', $id_producto)->get();

            foreach ($detallesCompra as $detalle) {
                DetalleInventario::firstOrCreate(
                    [
                        'id_inventario'     => $inventario->id_inventario,
                        'id_detalle_compra' => $detalle->id_detalle_compra,
                    ],
                    [
                        'stock_lote'        => $detalle->cantidad_producto,
                    ]
                );
            }
        } else {
            $detallesCompra = collect();
        }

        $query = DetalleInventario::join('detalle_compra', 'detalle_inventario.id_detalle_compra', '=', 'detalle_compra.id_detalle_compra')
            ->where('detalle_compra.id_producto', $id_producto)
            ->where('detalle_inventario.stock_lote', '>', 0)
            ->with('detalleCompra.compra')
            ->with('detalleCompra.producto')
            ->with('inventario.producto')
            ->select('detalle_inventario.*')
            ->distinct();

        $nombreProducto = Producto::where('id_producto', $id_producto)->value('nombre_producto');
        $porPagina = $request->input('PorPagina', 10);
        $detallesInventario = $query->paginate($porPagina);

        if ($request->ajax()) {
            return view('admin.detallesInventario.layoutDetallesInventario.tablaDetallesInventario', compact('detallesInventario', 'detallesCompra', 'nombreProducto'))->render();
        }
        return view('admin.detallesInventario.index', compact('detallesInventario', 'detallesCompra', 'nombreProducto'));
    }
}
