<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\productos\Categoria;
use App\Models\productos\Unidad;
use App\Models\productos\Producto;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $query = Producto::query();
        if ($request->filled('buscar_productos') && strlen(trim($request->buscar_productos)) >= 3) {
            $palabras = explode(' ', $request->buscar_productos);

            $query->where(function ($q) use ($palabras) {
                foreach ($palabras as $palabra) {
                    $q->where('nombre_producto', 'like', '%' . $palabra . '%');
                }
            });
        }


        if ($request->filled('categoria')) {
            $query->where('id_categoria_producto', $request->categoria);
        }

        if ($request->filled('unidad')) {
            $query->where('id_unidad_peso_producto', $request->unidad);
        }


        $porPagina = $request->input('PorPagina', 10); // 10 por defecto
        $productos = $query->paginate($porPagina);
        $categorias = Categoria::all();
        $unidades = Unidad::all();
        $user = Auth::user();
        if ($user->id_rol == 1) {
            // Si es petición AJAX, renderizar solo el contenido
            if ($request->ajax()) {
                return view('admin.productos.layoutproductos.tablaproductos', compact('productos', 'categorias', 'unidades'))->render();
            }

            return view('admin.productos.index', compact('productos', 'categorias', 'unidades', 'porPagina'));
        } elseif ($user->id_rol == 2) {
            if ($request->ajax()) {
                return view('user.productos.layoutproductos.tablaproductos', compact('productos', 'categorias', 'unidades'))->render();
            }

            return view('user.productos.index', compact('productos', 'categorias', 'unidades', 'porPagina'));
        }
    }

    // Genera los datos de los productos filtrados en un PDF
    public function generarPDF(Request $request)
    {
        $query = Producto::query();

        $categoria = null;
        $unidad = null;
        if ($request->filled('buscar_productos') && strlen(trim($request->buscar_productos)) >= 3) {
            $palabras = explode(' ', $request->buscar_productos);

            $query->where(function ($q) use ($palabras) {
                foreach ($palabras as $palabra) {
                    $q->where('nombre_producto', 'like', '%' . $palabra . '%');
                }
            });
        }

        if ($request->filled('categoria')) {
            $query->where('id_categoria_producto', $request->categoria);
            $categoria = Categoria::find($request->input('categoria'));
        }

        if ($request->filled('unidad')) {
            $query->where('id_unidad_peso_producto', $request->unidad);
            $unidad = Unidad::find($request->input('unidad'));
        }

        $cantidad = $query->count();
        $productos = $query->get();
        if ($cantidad == 0) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'No se puede generar el pdf si hay 0 registros'
            ]);
        }

        $data = [
            'titulo'    => 'Reporte de Compras Semilleros',
            'fecha'     => now()->format('d/m/Y'),
            'productos' => $productos,
            'categoria' => $categoria ? $categoria->categoria : 'Todas',
            'unidad'    => $unidad ? $unidad->unidad_peso : 'Todas',
        ];
        $user = Auth::user();
        if ($user->id_rol == 1) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reportes.productos_pdf', $data);
            return $pdf->download('reporte productos.pdf');
        } elseif ($user->id_rol == 2) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('user.reportes.productos_pdf', $data);
            return $pdf->download('reporte productos.pdf');
        }
    }



    //Maneja todos los datos del formulario create, valida que el producto exista ya.
    public function store(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:20',
            'precio_producto' => 'required|numeric|min:0|max:999999.99',
            'id_categoria_producto' => 'required|exists:categoria_producto,id_categoria_producto',
            'id_unidad_peso_producto' => 'required|exists:unidad_peso_producto,id_unidad_peso_producto',
        ]);

        $existingProduct = Producto::where('id_categoria_producto', $request->id_categoria_producto)
            ->where('id_unidad_peso_producto', $request->id_unidad_peso_producto)
            ->where('nombre_producto', $request->nombre_producto)
            ->where('id_producto', '!=', $producto->id_producto)
            ->first();
        $nombre = ucwords(strtolower($request->nombre_producto));
        if ($existingProduct) {
            return redirect()->route('admin.productos.index')->with('message', [
                'type' => 'error',
                'text' => 'El producto ya existe en la base de datos.'
            ]);
        } else {
            $producto = Producto::create([
                'nombre_producto' => $nombre,
                'precio_producto' => $request->precio_producto,
                'id_categoria_producto' => $request->id_unidad_peso_producto,
                'id_unidad_peso_producto' => $request->id_unidad_peso_producto,
            ]);
            return redirect()->route('admin.productos.index')->with('message', [
                'type' => 'success',
                'text' => 'El producto se ha creado correctamente.'
            ]);
        }
    }

    //Nos trae los datos para editar y para ver.
    public function show(Producto $producto)
    {
        return response()->json([
            'id_producto' => $producto->id_producto,
            'nombre_producto' => $producto->nombre_producto,
            'precio_producto' => $producto->precio_producto,
            'id_categoria_producto' => $producto->id_categoria_producto,
            'categoria' => $producto->categoria ? $producto->categoria->categoria : 'Sin categoría',
            'id_unidad_peso_producto' => $producto->id_unidad_peso_producto,
            'unidad' => $producto->unidad ? $producto->unidad->unidad_peso : 'Sin unidad',
        ]);
    }

    //Nos permite actualizar los registros de un producto, y valida que los datos no existan en otro producto.
    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre_producto' => 'required|string|max:20',
            'precio_producto' => 'required|numeric|min:0',
            'id_categoria_producto' => 'required|exists:categoria_producto,id_categoria_producto',
            'id_unidad_peso_producto' => 'required|exists:unidad_peso_producto,id_unidad_peso_producto',
        ]);
        $existingProduct = Producto::where('id_categoria_producto', $request->id_categoria_producto)
            ->where('id_unidad_peso_producto', $request->id_unidad_peso_producto)
            ->where('nombre_producto', $request->nombre_producto)
            ->where('id_producto', '!=', $producto->id_producto)
            ->first();

        $nombre = ucwords(strtolower($request->nombre_producto));

        if ($existingProduct) {
            return redirect()->route('admin.productos.index')->with('message', [
                'type' => 'error',
                'text' => 'El producto ya existe en la base de datos.'
            ]);
        } else {
            $producto->nombre_producto = $nombre;
            $producto->precio_producto = $request->precio_producto;
            $producto->id_categoria_producto = $request->id_categoria_producto;
            $producto->id_unidad_peso_producto = $request->id_unidad_peso_producto;
            $producto->save();
            return redirect()->route('admin.productos.index')->with('message', [
                'type' => 'success',
                'text' => 'El producto se ha actualizado correctamente.'
            ]);
        }
    }

    //Nos permite eliminar productos, en caso de que
    //Antes de eliminar valida que no este asociado a otros registros, para evitar eliminar registros de cascada
    public function destroy($id_producto)
    {
        $producto = Producto::find($id_producto);
        if (!$producto) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'El producto no existe en la base de datos.'
            ]);
        }

        // Verificar si tiene compras o ventas asociadas
        if ($producto->detalleCompra()->exists() || $producto->detalleVenta()->exists()) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'No se puede eliminar el producto porque tiene registros asociados en compras o ventas.'
            ]);
        }
        foreach ($producto->detalleCompra as $detalleCompra) {
            $detalleCompra->detalleInventario()->delete();
        }
        $producto->detalleCompra()->delete();
        $producto->detalleVenta()->delete();
        $producto->inventario()->delete();
        $producto->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'El producto se ha eliminado correctamente.'
        ]);
    }
}
