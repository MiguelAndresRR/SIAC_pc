<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\compras\DetalleCompra;
use App\Models\productos\Producto;
use App\Models\compras\Compras;

class DetallesComprasController extends Controller
{
    // Mostrar lista de detalles de compra filtrados por compra
    public function index(Request $request, $id_compra)
    {
        // Crear consulta base filtrando por id_compra
        $query = DetalleCompra::query()->where('id_compra', $id_compra);
        if ($request->filled('productoSelect')) {
            $query->whereHas('productos', function ($query) use ($request) {
                $query->where('nombre_producto', 'like', '%' . $request->productoSelect . '%');
            });
        }
        if ($request->filled('proveedorSelect')) {
            $query->whereHas('proveedor', function ($query) use ($request) {
                $query->where('nombre_proveedor', 'like', '%' . $request->proveedorSelect . '%');
            });
        }
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
        $detallesCompras = $query->paginate($porPagina);

        // Obtener lista de productos para selección
        $productos = Producto::with('unidad')->get();
        $compra = Compras::find($id_compra);
        // Si es petición AJAX, renderizar solo el contenido
        if ($request->ajax()) {
            return view('admin.detallesCompras.index', compact('detallesCompras', 'id_compra', 'productos', 'compra'))->render();
        }

        // Vista completa
        return view('admin.detallesCompras.index', compact('detallesCompras', 'id_compra', 'productos', 'compra'));
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
            'cantidad_producto' => $detalleCompra->cantidad_producto,
            'precio_unitario' => $detalleCompra->precio_unitario,
            'subtotal_compra' => $detalleCompra->subtotal_compra
        ]);
    }

    public function create($id_compra)
    {
        // Obtener lista de productos para el formulario
        $productos = Producto::all();
        $compra = Compras::find($id_compra);
        return view('admin.detallesCompras.create', compact('productos', 'id_compra', 'compra'));
    }

    // Guardar un nuevo detalle de compra
    public function store(Request $request, $id_compra)
    {
        // Validar datos recibidos
        $request->validate([
            'id_compra' => 'required|exists:compra,id_compra',
            'id_producto' => 'required|exists:producto,id_producto',
            'cantidad_producto' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0'
        ]);

        // Calcular subtotal
        $subtotal_compra = $request->cantidad_producto * $request->precio_unitario;

        // Crear registro
        $detalleCompra = DetalleCompra::create([
            'id_compra' => $request->id_compra,
            'id_producto' => $request->id_producto,
            'cantidad_producto' => $request->cantidad_producto,
            'precio_unitario' => $request->precio_unitario,
            'subtotal_compra' => $subtotal_compra
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.detallesCompras.index', $id_compra)->with('message', [
            'type' => 'success',
            'text' => 'El detalle de compra se ha creado correctamente.'
        ]);
    }

    // Actualizar un detalle de compra existente
    public function update(Request $request, DetalleCompra $detalleCompra)
    {
        // Validar datos
        $request->validate([
            'id_compra' => 'required|exists:compra,id_compra',
            'id_producto' => 'required|exists:producto,id_producto',
            'cantidad_producto' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0'
        ]);

        // Calcular subtotal
        $subtotal = $request->cantidad_producto * $request->precio_unitario;

        // Actualizar campos
        $detalleCompra->id_compra = $request->id_compra;
        $detalleCompra->id_producto = $request->id_producto;
        $detalleCompra->cantidad_producto = $request->cantidad_producto;
        $detalleCompra->precio_unitario = $request->precio_unitario;
        $detalleCompra->subtotal_compra = $subtotal;
        $detalleCompra->save();

        // Redirigir con mensaje
        return redirect()->route('admin.detallesCompras.index', $detalleCompra->id_compra)->with('message', [
            'type' => 'success',
            'text' => 'El detalle de compra se ha actualizado correctamente.'
        ]);
    }

    // Eliminar un detalle de compra
    public function destroy($id_detalle_compra)
    {
        // Buscar registro
        $detalleCompra = DetalleCompra::find($id_detalle_compra);
        if (! $detalleCompra) {
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
