<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\compras\DetalleCompra;
use App\Models\compras\Compra;
use App\Models\productos\Producto;
use App\Models\proveedor\Proveedor;
use Illuminate\Support\Facades\Auth;

class DetallesComprasController extends Controller
{
    public function index(Request $request, $id_compra)
    {
        $porPagina = $request->input('PorPagina', 10);

        $detallesCompras = DetalleCompra::where('id_compra', $id_compra)
            ->paginate($porPagina);

        if ($request->ajax()) {
            return view('admin.detallesCompras.index', compact('detallesCompras', 'id_compra'))->render();
        }

        return view('admin.detallesCompras.index', compact('detallesCompras', 'id_compra'));
    }

    public function show(DetalleCompra $detalleCompra)
    {
        return response()->json([
            'id_detalle_compra' => $detalleCompra->id_detalle_compra,
            'id_compra' => $detalleCompra->id_compra,
            'compra' => $detalleCompra->compra ? $detalleCompra->compra->id_compra : 'sin compra',
            'id_producto' => $detalleCompra->id_producto,
            'producto' => $detalleCompra->producto ? $detalleCompra->producto->nombre_producto : 'sin producto',
            'cantidad' => $detalleCompra->cantidad,
            'precio_unitario' => $detalleCompra->precio_unitario,
            'subtotal' => $detalleCompra->subtotal
        ]);
    }

    public function store(Request $request, DetalleCompra $detalleCompra)
    {
        $request->validate([
            'id_compra' => 'required|exists:compras,id_compra',
            'id_producto' => 'required|exists:producto,id_producto',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0'
        ]);

        $subtotal = $request->cantidad * $request->precio_unitario;

        $detalleCompra = DetalleCompra::create([
            'id_compra' => $request->id_compra,
            'id_producto' => $request->id_producto,
            'cantidad' => $request->cantidad,
            'precio_unitario' => $request->precio_unitario,
            'subtotal' => $subtotal
        ]);

        // Actualizar el stock del producto
        // $producto = Producto::find($request->id_producto);
        // if ($producto) {
        //     $producto->stock += $request->cantidad;
        //     $producto->save();
        // }

        return redirect()->route('admin.compras.index')->with('message', [
            'type' => 'success',
            'text' => 'El detalle de compra se ha creado correctamente.'
        ]);
    }

    public function update(Request $request, DetalleCompra $detalleCompra)
    {
        $request->validate([
            'id_compra' => 'required|exists:compras,id_compra',
            'id_producto' => 'required|exists:producto,id_producto',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0'
        ]);

        $subtotal = $request->cantidad * $request->precio_unitario;

        $detalleCompra->id_compra = $request->id_compra;
        $detalleCompra->id_producto = $request->id_producto;
        $detalleCompra->cantidad = $request->cantidad;
        $detalleCompra->precio_unitario = $request->precio_unitario;
        $detalleCompra->subtotal = $subtotal;
        $detalleCompra->save();
        // Actualizar el stock del producto
        // $producto = Producto::find($request->id_producto);
        // if ($producto) {
        //     $producto->stock += $request->cantidad;
        //     $producto->save();
        // }
        return redirect()->route('admin.compras.index')->with('message', [
            'type' => 'success',
            'text' => 'El detalle de compra se ha actualizado correctamente.'
        ]);
    }

    public function destroy($id_detalle_compra)
    {
        $detalleCompra = DetalleCompra::find($id_detalle_compra);
        if (! $id_detalle_compra) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'El detalle de compra no existe en la base de datos.'
            ]);
        }
        $detalleCompra->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'El detalle de compra ha sido eliminado correctamente.'
        ]);
    }
}
