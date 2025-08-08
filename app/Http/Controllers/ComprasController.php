<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\compras\DetalleCompra;
use App\Models\compras\Compras;

class ComprasController extends Controller
{
    public function index(Request $request)
    {
        $query = Compras::query();
        //filtros

        $porPagina = $request->input('PorPagina', 10);
        $compras = $query->paginate($porPagina);
        if ($request->ajax()) {
            return view('admin.compras.layoutcompras.tablacompras', compact('compras'))->render();
        }

        return view('admin.compras.index', compact('compras'));
    }

    public function store(Request $request, Compras $compra)
    {
        $request->validate([
            'fecha_compra' => 'required|date',
            'id_proveedor' => 'required|exists:nombre_proveedor,id_proveedor'
        ]);

        $compra = Compras::create([
            'fecha_compra' => $request->fecha_compra,
            'id_usuario' => Auth::id(),
            'id_proveedor' => $request->id_proveedor
        ]);
        return redirect()->route('admin.compras.index')->with('message', [
            'type' => 'success',
            'text' => 'La compra se ha creado correctamente.'
        ]);
    }

    public function show(Compras $compra)
    {
        return response()->json([
            'id_compra' => $compra->id_compra,
            'fecha_compra' => $compra->fecha_compra,
            'id_usuario' => $compra->id_usuario,
            'usuario' => $compra->usuario ? $compra->usuario->nombre_usuario : 'sin usuario',
            'id_proveedor' => $compra->id_proveedor,
            'proveedor' => $compra->proveedor ? $compra->proveedor->nombre_proveedor : 'sin proveedor'
        ]);
    }

    public function update(Request $request, Compras $compra)
    {
        $request->validate([
            'fecha_compra' => 'required|date',
            'id_proveedor' => 'required|exists:nombre_proveedor,id_proveedor'
        ]);

        $compra->fecha_compra = $request->fecha_compra;
        $compra->id_proveedor = $request->id_proveedor;
        $compra->save();
        return redirect()->route('admin.compras.index')->with('message', [
            'type' => 'success',
            'text' => 'La compra se ha actualizado correctamente'
        ]);
    }

    public function destroy($id_compra)
    {
        $compra = Compras::find($id_compra);
        if (! $compra) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'LA compra no existe en la base de datos.'
            ]);
        }
        $compra->detalleCompra()->delete();
        $compra->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'La compra y sus detalles han sido eliminados correctamente.'
        ]);
    }
}
// class DetallesCompraController extends Controller
// {
//     public function index(Request $request)
//     {
//         $query = DetalleCompra::query();
//         // if ($request->filled('X')) {
//         //     $query->where('X', 'like', '%' . $request->$X);
//         // }
//         // if ($request->filled('X')) {
//         //     $query->where('X', 'like', '%' . $request->$X);
//         // }

//         $porPagina = $request->input('PorPagina', 10);
//         $detallesCompras = $query->paginate($porPagina);
//         if ($request->ajax()) {
//             return view('', compact('detallesCompras'))->render();//faltan estas vistas
//         }

//         return view('', compact('detallesCompras'))->render(); //faltan estas vistas
//     }
//     public function show(DetalleCompra $detalleCompra)
//     {
//     }

//     public function edit(DetalleCompra $detalleCompra)
//     {
//     }

//     public function update(Request $request, DetalleCompra $detalleCompra)
//     {

//     }

//     public function destroy($id_detalle_compra)
//     {
//         $detalleCompra = DetalleCompra::find($id_detalle_compra);
//         if(! $id_detalle_compra) {
//             return redirect()->back()->with('message',[
//                 'type'=> 'error',
//                 'text'=> 'El detalle de compra no existe en la base de datos.'
//             ]);
//         }
//         $detalleCompra->delete();
//         return redirect()->back()->with('message', [
//             'type'=> 'success',
//             'text'=> 'El detalle de compra ha sido eliminado correctamente.'
//         ]);

//     }
// }