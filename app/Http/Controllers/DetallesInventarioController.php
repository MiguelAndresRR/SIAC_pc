<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inventario\DetalleInventario;
use App\Models\productos\Producto;
use App\Models\inventario\Inventario;
use App\Models\compras\DetalleCompra;
use App\Models\compras\Compra;
use App\Models\ventas\DetalleVenta;

class DetallesInventarioController extends Controller
{
    public function index(Request $request, $id_producto)
    {
        $detallesCompra = DetalleCompra::where('id_producto', $id_producto)->get();

        foreach ($detallesCompra as $detalle) {
            DetalleInventario::firstOrCreate(
                ['id_detalle_compra' => $detalle->id_detalle_compra],
                ['stock_lote' => $detalle->cantidad_producto]
            );
        }
        $query = DetalleInventario::join('detalle_compra', 'detalle_inventario.id_detalle_compra', '=', 'detalle_compra.id_detalle_compra')
            ->where('detalle_compra.id_producto', $id_producto)
            ->with('detalleCompra.compra')
            ->select('detalle_inventario.*');
        $porPagina = $request->input('PorPagina', 10);
        $detallesInventario = $query->paginate($porPagina);

        if ($request->ajax()) {
            return view('admin.inventario.layoutinventario.tabladetalleinventario', compact('detallesInventario'))->render();
        }
        return view('admin.inventario.layoutinventario.tabladetalleinventario', compact('detallesInventario'));
    }
}
