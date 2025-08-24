<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ventas\DetalleVenta;
use App\Models\ventas\Venta;
use App\Models\productos\Producto;



class DetallesVentasController extends Controller
{
    // Mostrar lista de detalles de compra filtrados por compra
    public function index(Request $request, $id_venta)
    {
        $detalleCompras = DetalleVenta::where('id_venta', $id_venta)->get();
        $total_venta = DetalleVenta::where('id_venta', $id_venta)->sum('subtotal_venta');
        $venta = Venta::findOrFail($id_venta);
        $venta->total_venta = $total_venta;
        $venta->save();

        $query = DetalleVenta::query()->where('id_venta', $id_venta);
        // Crear consulta base filtrando por id_compra
        // if ($request->filled('productoSelect')) {
        //     $query->whereHas('producto', function ($query) use ($request) {
        //         $query->where('id_producto', 'like', '%' . $request->productoSelect . '%');
        //     });
        // }
        // Si hay búsqueda de productos con mínimo 3 caracteres
        // if ($request->filled('buscar_productos') && strlen(trim($request->buscar_productos)) >= 3) {
        //     $palabras = explode(' ', $request->buscar_productos);

        //     $query->whereHas('producto', function ($q) use ($palabras) {
        //         foreach ($palabras as $palabra) {
        //             $q->where('nombre_producto', 'like', '%' . $palabra . '%');
        //         }
        //     });
        // }

        // Paginación
        $porPagina = $request->input('PorPagina', 10);
        $detallesVentas = $query->paginate($porPagina);

        // Obtener lista de productos para selección
        $venta = Venta::find($id_venta);
        // Si es petición AJAX, renderizar solo el contenido
        if ($request->ajax()) {
            return view('admin.detallesVentas.layoutdetallesVentas.tabladetallesVentas', compact('detallesVentas'))->render();
        }

        // Vista completa
        return view('admin.detallesVentas.index', compact('detallesVentas'));
    }

    // Mostrar un detalle de compra específico en JSON
    public function show(DetalleVenta $detalleVenta)
    {
        return response()->json([
            'id_venta' => $detalleVenta->id_venta,
            'id_producto' => $detalleVenta->id_producto,
            'producto' => $detalleVenta->producto ? $detalleVenta->producto->nombre_producto : 'sin producto',
            'cantidad_venta' => $detalleVenta->cantidad_venta,
            'subtotal_venta' => $detalleVenta->subtotal_venta

        ]);
    }



    public function create($id_venta)
    {
        // Obtener lista de productos para el formulario
        $productos = Producto::all();
        $venta = Venta::find($id_venta);
        return view('admin.detallesVentas.create', compact('productos', 'id_venta', 'venta'));
    }

    // Guardar un nuevo detalle de compra
    public function store(Request $request, $id_venta ,$id_producto)
    {
        // Validar datos recibidos
        $request->validate([
            'id_venta' => 'required|exists:venta,id_venta',
            'id_producto' => 'required|exists:producto,id_producto',
            'cantidad_venta' => 'required|integer|min:1',
            'subtotal_venta' => 'required|numeric|min:0'
        ]);

        // Calcular subtotal
        $subtotal_venta = $request->cantidad_venta * $id_producto->precio_producto;

        // Crear registro
        $detalleVenta = DetalleVenta::create([
            'id_venta' => $request->id_venta,
            'id_producto' => $request->id_producto,
            'cantidad_producto' => $request->cantidad_producto,
            'subtotal_compra' => $subtotal_venta
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('admin.detallesVentas.index', $id_venta)->with('message', [
            'type' => 'success',
            'text' => 'El detalle de la venta se ha creado correctamente.'
        ]);
    }
    public function edit($id_detalle_venta)
    {
        $detalle = DetalleVenta::with(['venta', 'producto'])->find($id_detalle_venta);

        if (!$detalle) {
            return response()->json([
                'error' => 'Detalle no encontrado'
            ], 404);
        }

        return response()->json([
            'id_detalle_venta'  => $detalle->id_venta,
            'id_venta'          => $detalle->id_compra,
            'id_producto'       => $detalle->id_producto,
            'cantidad_venta'    => $detalle->cantidad_producto,
            'precio_producto'   => $detalle->precio_unitario,
            'subtotal_venta'   => $detalle->subtotal_compra,
            'producto'          => $detalle->producto->nombre_producto ?? 'Sin producto',
            'venta'            => $detalle->venta->id_venta ?? 'Sin venta',
        ]);
    }

    // Actualizar un detalle de venta existente
    public function update(Request $request, DetalleVenta $detalleVenta)
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
        $detalleVenta->id_venta = $request->id_venta;
        $detalleVenta->id_producto = $request->id_producto;
        $detalleVenta->cantidad_venta = $request->cantidad_venta;
        $detalleVenta->subtotal_venta = $subtotal;
        $detalleVenta->save();



        // Redirigir con mensaje
        return redirect()->route('admin.detallesVentas.index', $detalleVenta->id_venta)->with('message', [
            'type' => 'success',
            'text' => 'El detalle de la venta se ha actualizado correctamente.'
        ]);
    }

    // Eliminar un detalle de compra
    public function destroy($id_detalle_venta)
    {
        // Buscar registro
        $detalleVenta = DetalleVenta::find($id_detalle_venta);
        if (! $detalleVenta) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'El detalle de la venta no existe en la base de datos.'
            ]);
        }

        // Eliminar registro
        $detalleVenta->delete();

        // Redirigir con mensaje
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'El detalle de la venta ha sido eliminado correctamente.'
        ]);
    }
}
