<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\compras\DetalleCompra;
use App\Models\productos\Producto;
use App\Models\compras\Compra;
use App\Models\inventario\Inventario;
use App\Models\inventario\DetalleInventario;
use App\Models\ventas\DetalleVenta;

class DetallesComprasController extends Controller
{
    // Mostrar lista de detalles de compra filtrados por compra
    public function index(Request $request, $id_compra)
    {
        $detalleCompras = DetalleCompra::where('id_compra', $id_compra)->get();
        $total_compra = DetalleCompra::where('id_compra', $id_compra)->sum('subtotal_compra');
        $compra = Compra::findOrFail($id_compra);
        $compra->total_compra = $total_compra;
        $compra->save();

        $query = DetalleCompra::query()->where('id_compra', $id_compra);
        // Crear consulta base filtrando por id_compra
        if ($request->filled('productoSelect')) {
            $query->whereHas('producto', function ($query) use ($request) {
                $query->where('id_producto', 'like', '%' . $request->productoSelect . '%');
            });
        }
        // Si hay búsqueda de productos con mínimo 3 caracteres
        if ($request->filled('buscar_productos') && strlen(trim($request->buscar_productos)) >= 3) {
            $palabras = explode(' ', $request->buscar_productos);

            $query->whereHas('producto', function ($q) use ($palabras) {
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
        $compra = Compra::find($id_compra);
        // Si es petición AJAX, renderizar solo el contenido
        if ($request->ajax()) {
            return view('admin.detallesCompras.layoutdetallesCompras.tabladetallesCompras', compact('detallesCompras', 'id_compra', 'productos', 'compra'))->render();
        }

        // Vista completa
        return view('admin.detallesCompras.index', compact('detallesCompras', 'id_compra', 'productos', 'compra', 'total_compra'));
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
            'subtotal_compra' => $detalleCompra->subtotal_compra,
            'fecha_vencimiento' => $detalleCompra->fecha_vencimiento
        ]);
    }



    public function create($id_compra)
    {
        // Obtener lista de productos para el formulario
        $productos = Producto::all();
        $compra = Compra::find($id_compra);
        return view('admin.detallesCompras.create', compact('productos', 'id_compra', 'compra'));
    }

    // Guardar un nuevo detalle de compra
    public function store(Request $request, $id_compra)
    {
        // Validar datos recibidos
        $request->validate([
            'id_producto' => 'required|exists:producto,id_producto',
            'cantidad_producto' => 'required|integer|min:1',
            'precio_unitario' => 'required|numeric|min:0',
            'fecha_vencimiento' => 'nullable|date'
        ]);
        // Calcular subtotal
        $subtotal_compra = $request->cantidad_producto * $request->precio_unitario;
        // Crear registro detalle compra
        $detalleCompra = DetalleCompra::create([
            'id_compra' => $id_compra,
            'id_producto' => $request->id_producto,
            'cantidad_producto' => $request->cantidad_producto,
            'precio_unitario' => $request->precio_unitario,
            'subtotal_compra' => $subtotal_compra,
            'fecha_vencimiento' => $request->fecha_vencimiento
        ]);
        // Actualizar inventario
        $inventario = Inventario::where('id_producto', $request->id_producto)->first();
        if ($inventario) {
            $inventario->stock_total += $request->cantidad_producto;
            $inventario->save();
        } else {
            Inventario::create([
                'id_producto' => $request->id_producto,
                'stock_total' => $request->cantidad_producto,
                // otros campos si son necesarios
            ]);
        }
        // Actualizar detalle inventario
        $inventario = Inventario::where('id_producto', $request->id_producto)->first();
        if ($inventario) {
            $detallesCompra = DetalleCompra::where('id_producto', $request->id_producto)->get();
            foreach ($detallesCompra as $detalle) {
                DetalleInventario::firstOrCreate(
                    [
                        'id_inventario' => $inventario->id_inventario,
                        'id_detalle_compra' => $detalle->id_detalle_compra,
                    ],
                    [
                        'stock_lote' => $detalle->cantidad_producto,
                    ]
                );
            }
        }
        // Redirigir con mensaje de éxito
        return redirect()->route('admin.detallesCompras.index', $id_compra)->with('message', [
            'type' => 'success',
            'text' => 'El detalle de compra se ha creado correctamente y el inventario actualizado.'
        ]);
    }

    public function edit($id_detalle_compra)
    {
        $detalle = DetalleCompra::with(['compra', 'producto'])->find($id_detalle_compra);

        if (!$detalle) {
            return response()->json([
                'error' => 'Detalle no encontrado'
            ], 404);
        }

        return response()->json([
            'id_detalle_compra' => $detalle->id_detalle_compra,
            'id_compra' => $detalle->id_compra,
            'id_producto' => $detalle->id_producto,
            'cantidad_producto' => $detalle->cantidad_producto,
            'precio_unitario' => $detalle->precio_unitario,
            'subtotal_compra' => $detalle->subtotal_compra,
            'producto' => $detalle->producto->nombre_producto ?? 'Sin producto',
            'compra' => $detalle->compra->id_compra ?? 'Sin compra',
            'fecha_vencimiento' => $detalle->fecha_vencimiento ?? 'Sin fecha'
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
        'precio_unitario' => 'required|numeric|min:0',
        'fecha_vencimiento' => 'nullable|date'
    ]);

    // Stock actual en inventario de este detalle
    $stock_lote = DetalleInventario::where('id_detalle_compra', $detalleCompra->id_detalle_compra)
        ->value('stock_lote') ?? 0;

    // Diferencia con lo que viene del request
    $validarStock = $request->cantidad_producto - $detalleCompra->cantidad_producto;

    // Validar que no quede negativo
    if ($stock_lote + $validarStock < 0) {
        return redirect()->back()->with('message', [
            'type' => 'error',
            'text' => 'No se puede actualizar porque el inventario quedaría negativo.'
        ]);
    }

    // Actualizar detalle compra
    $detalleCompra->update([
        'id_compra' => $request->id_compra,
        'id_producto' => $request->id_producto,
        'cantidad_producto' => $request->cantidad_producto,
        'precio_unitario' => $request->precio_unitario,
        'subtotal_compra' => $request->cantidad_producto * $request->precio_unitario,
        'fecha_vencimiento' => $request->fecha_vencimiento,
    ]);

    // Buscar o crear inventario asociado al producto
    $inventario = Inventario::firstOrCreate(
        ['id_producto' => $request->id_producto],
        ['stock_total' => 0]
    );

    // Nuevo stock del lote
    $nuevo_stock = $stock_lote + $validarStock;

    // Actualizar o crear detalle inventario
    DetalleInventario::updateOrCreate(
        [
            'id_inventario' => $inventario->id_inventario,
            'id_detalle_compra' => $detalleCompra->id_detalle_compra,
        ],
        [
            'stock_lote' => $nuevo_stock,
        ]
    );

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
        if (!$detalleCompra) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'El detalle de compra no existe en la base de datos.'
            ]);
        }

        $stock_lote = DetalleInventario::where('id_detalle_compra', $id_detalle_compra)->value('stock_lote');
        if ($detalleCompra->detalleInventario()->exists() && $detalleCompra->cantidad_producto == $stock_lote) {
            $detalleCompra->detalleInventario()->delete();
            $detalleCompra->delete();
            return redirect()->back()->with('message', [
                'type' => 'success',
                'text' => 'El detalle de compra ha sido eliminado correctamente.'
            ]);
        } else {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'El lote ya presento ventas y no se puede borrar.'
            ]);
        }
    }
}
