<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\compras\DetalleCompra;
use App\Models\compras\Compras;

class ComprasController extends Controller
{
    public function index(Request $request)
    {
        $query = Compras::with(['proveedor', 'usuario', 'detalleCompra.producto']);

        $porPagina = $request->input('entries', 15);
        $compras = $query->paginate($porPagina)->appends($request->query());

        if ($request->ajax()) {
            return view('admin.compras.layoutcompras.tablacompras', compact('compras'))->render();
        }

        return view('admin.compras.index', compact('compras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'fecha_compra' => 'required|date',
            'productos' => 'required|array|min:1',
            'productos.*.id_producto' => 'required|exists:productos,id_producto',
            'productos.*.cantidad_producto' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        $id_usuario = session('user_id');
        if (!$id_usuario) {
            return redirect()->route('login')->with('message', [
                'type' => 'error',
                'text' => 'Sesión no válida. Por favor, inicia sesión nuevamente.'
            ]);
        }

        // Crear la compra principal
        $compra = Compras::create([
            'id_proveedor' => $request->id_proveedor,
            'fecha_compra' => $request->fecha_compra,
            'id_usuario' => $id_usuario
        ]);

        $total_compra = 0;

        // Crear los detalles de compra
        foreach ($request->productos as $producto) {
            $subtotal = $producto['cantidad_producto'] * $producto['precio_unitario'];
            $total_compra += $subtotal;

            DetalleCompra::create([
                'id_compra' => $compra->id_compra,
                'id_producto' => $producto['id_producto'],
                'cantidad_producto' => $producto['cantidad_producto'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal_compra' => $subtotal,
                'total_compra' => $subtotal
            ]);
        }

        return redirect()->route('admin.compras.index')->with('message', [
            'type' => 'success',
            'text' => 'La compra se ha creado correctamente.'
        ]);
    }
    public function show(Compras $compra)
    {
        $compra->load(['proveedor', 'usuario', 'detalleCompra.producto']);
        
        return response()->json([
            'id_compra' => $compra->id_compra,
            'proveedor' => $compra->proveedor->nombre_proveedor,
            'usuario' => $compra->usuario->user,
            'fecha_compra' => $compra->fecha_compra,
            'detalles' => $compra->detalleCompra->map(function($detalle) {
                return [
                    'producto' => $detalle->producto->nombre_producto,
                    'cantidad' => $detalle->cantidad_producto,
                    'precio_unitario' => $detalle->precio_unitario,
                    'subtotal' => $detalle->subtotal_compra
                ];
            }),
            'total_compra' => $compra->detalleCompra->sum('subtotal_compra')
        ]);
    }

    public function edit(DetalleCompra $detalleCompra)
    {
        $detalleCompra = DetalleCompra::all();

        return view('admin.compras.index', compact('detalleCompra'));
    }

    public function update(Request $request, Compras $compra)
    {
        $request->validate([
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'fecha_compra' => 'required|date',
            'productos' => 'required|array|min:1',
            'productos.*.id_producto' => 'required|exists:productos,id_producto',
            'productos.*.cantidad_producto' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
        ]);

        // Actualizar la compra principal
        $compra->update([
            'id_proveedor' => $request->id_proveedor,
            'fecha_compra' => $request->fecha_compra
        ]);

        // Eliminar detalles existentes
        $compra->detalleCompra()->delete();

        // Crear nuevos detalles
        foreach ($request->productos as $producto) {
            $subtotal = $producto['cantidad_producto'] * $producto['precio_unitario'];

            DetalleCompra::create([
                'id_compra' => $compra->id_compra,
                'id_producto' => $producto['id_producto'],
                'cantidad_producto' => $producto['cantidad_producto'],
                'precio_unitario' => $producto['precio_unitario'],
                'subtotal_compra' => $subtotal,
                'total_compra' => $subtotal
            ]);
        }

        return redirect()->route('admin.compras.index')->with('message', [
            'type' => 'success',
            'text' => 'La compra se ha actualizado correctamente.'
        ]);
    }

    public function destroy($id_compra, $id_detalle_compra)
    {
        $detalleCompra = DetalleCompra::find($id_detalle_compra );
        $compra = Compras::find($id_compra);
        if (!$detalleCompra || !$compra) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'La compra no existe en la base de datos.'
            ]);
        }

        $detalleCompra->delete();
        $compra->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'La compra se ha eliminado correctamente.'
        ]);
    }
}
