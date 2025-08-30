<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\inventario\DetalleInventario;
use App\Models\compras\DetalleCompra;


class DetallesInventarioController extends Controller
{
    public function index(Request $request, $id_producto, DetalleCompra $id_detalle_compra)
    {
        $detallesCompra = DetalleCompra::where('id_producto', $id_producto)->get();
        foreach ($detallesCompra as $detalle) {
            DetalleInventario::firstOrCreate(
                ['id_detalle_compra' => $detalle->id_detalle_compra],
                ['stock_lote' => $detalle->cantidad_producto],
            );
        }
        $query = DetalleInventario::join('detalle_compra', 'detalle_inventario.id_detalle_compra', '=', 'detalle_compra.id_detalle_compra')
            ->where('detalle_compra.id_producto', $id_producto)
            ->with('detalleCompra.compra')
            ->with('detalleCompra.producto')
            ->select('detalle_inventario.*');
        $porPagina = $request->input('PorPagina', 10);
        $detallesInventario = $query->paginate($porPagina);

        if ($request->ajax()) {
            return view('admin.detallesInventario.layoutDetallesInventario.tablaDetallesInventario', compact('detallesInventario', 'detallesCompra'))->render();
        }
        return view('admin.detallesInventario.index', compact('detallesInventario', 'detallesCompra'));
    }
}
