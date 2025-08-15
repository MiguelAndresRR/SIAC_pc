<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\compras\DetalleCompra;
use App\Models\productos\Producto;

class DetallesComprasController extends Controller
{
    // Mostrar lista de detalles de compra filtrados por compra
    public function index(Request $request, $id_compra)
    {
        // Crear consulta base filtrando por id_compra
        $query = DetalleCompra::query()->where('id_compra', $id_compra);

        // Si hay búsqueda de productos con mínimo 3 caracteres
        if ($request->filled('buscar_productos') && strlen(trim($request->buscar_productos)) >= 3) {
            $palabras = explode(' ', $request->buscar_productos);

            // Buscar coincidencias en nombre de producto
            $query->where(function ($q) use ($palabras) {
                foreach ($palabras as $palabra) {
                    $q->where('nombre_producto', 'like', '%' . $palabra . '%');
                }
            });
        }

        // Paginación
        $porPagina = $request->input('PorPagina', 10);
        $detallesCompras = DetalleCompra::where('id_compra', $id_compra)
            ->paginate($porPagina);

        // Obtener lista de productos para selección
        $productos = Producto::all();

        // Si es petición AJAX, renderizar solo el contenido
        if ($request->ajax()) {
            return view('admin.detallesCompras.index', compact('detallesCompras', 'id_compra', 'productos'))->render();
        }

        // Vista completa
        return view('admin.detallesCompras.index', compact('detallesCompras', 'id_compra', 'productos'));
    }

    // Mostrar un detalle de compra específico en JSON
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

    // Guardar un nuevo detalle de compra
    public function store(Request $request, DetalleCompra $detalleCompra)
    {
        // Validar datos recibidos
        $request->validate([
            'id_compra' => 'required|exists:compras,id_compra',
            'id_producto' => 'required|exists:producto,id_producto',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0'
        ]);

        // Calcular subtotal
        $subtotal = $request->cantidad * $request->precio_unitario;

        // Crear registro
        $detalleCompra = DetalleCompra::create([
            'id_compra' => $request->id_compra,
            'id_producto' => $request->id_producto,
            'cantidad' => $request->cantidad,
            'precio_unitario' => $request->precio_unitario,
            'subtotal' => $subtotal
        ]);

        // (Opcional) Actualizar stock del producto
        /*
        $producto = Producto::find($request->id_producto);
        if ($producto) {
            $producto->stock += $request->cantidad;
            $producto->save();
        }
        */

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.compras.index')->with('message', [
            'type' => 'success',
            'text' => 'El detalle de compra se ha creado correctamente.'
        ]);
    }

    // Actualizar un detalle de compra existente
    public function update(Request $request, DetalleCompra $detalleCompra)
    {
        // Validar datos
        $request->validate([
            'id_compra' => 'required|exists:compras,id_compra',
            'id_producto' => 'required|exists:producto,id_producto',
            'cantidad' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0'
        ]);

        // Calcular subtotal
        $subtotal = $request->cantidad * $request->precio_unitario;

        // Actualizar campos
        $detalleCompra->id_compra = $request->id_compra;
        $detalleCompra->id_producto = $request->id_producto;
        $detalleCompra->cantidad = $request->cantidad;
        $detalleCompra->precio_unitario = $request->precio_unitario;
        $detalleCompra->subtotal = $subtotal;
        $detalleCompra->save();

        // (Opcional) Actualizar stock del producto
        /*
        $producto = Producto::find($request->id_producto);
        if ($producto) {
            $producto->stock += $request->cantidad;
            $producto->save();
        }
        */

        // Redirigir con mensaje
        return redirect()->route('admin.compras.index')->with('message', [
            'type' => 'success',
            'text' => 'El detalle de compra se ha actualizado correctamente.'
        ]);
    }

    // Eliminar un detalle de compra
    public function destroy($id_detalle_compra)
    {
        // Buscar registro
        $detalleCompra = DetalleCompra::find($id_detalle_compra);
        if (! $id_detalle_compra) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'El detalle de compra no existe en la base de datos.'
            ]);
        }

        // Eliminar registro
        $detalleCompra->delete();

        // Redirigir con mensaje
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'El detalle de compra ha sido eliminado correctamente.'
        ]);
    }
}
