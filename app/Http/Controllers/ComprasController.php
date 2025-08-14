<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\compras\DetalleCompra;
use App\Models\compras\Compras;
use App\Models\productos\Producto;
use App\Models\proveedor\Proveedor;

class ComprasController extends Controller
{
    public function index(Request $request)
    {
        $query = Compras::query();

        if ($request->filled('fecha_desde') && $request->filled('fecha_hasta')) {
            $query->whereBetween('fecha_compra', [
                $request->fecha_desde,
                $request->fecha_hasta
            ]);
        }

        if ($request->filled('buscar_proveedor') && strlen(trim($request->buscar_proveedor)) >= 3) {
            $palabras = explode(' ', $request->buscar_proveedor);

            $query->where(function ($q) use ($palabras) {
                foreach ($palabras as $palabra) {
                    $q->where('nombre_proveedor', 'like', '%' . $palabra . '%');
                }
            });
        }

        $porPagina = $request->input('PorPagina', 10);
        $compras = $query->paginate($porPagina);
        $proveedores = Proveedor::all();
        if ($request->ajax()) {
            return view('admin.compras.layoutcompras.tablacompras', compact('compras', 'proveedores'))->render();
        }

        return view('admin.compras.index', compact('compras', 'proveedores'));
    }

    public function store(Request $request, Compras $compra)
    {
        $request->validate([
            'fecha_compra' => 'required|date',
            'id_proveedor' => 'required|exists:proveedor,id_proveedor'

        ]);

        $compra = Compras::create([
            'fecha_compra' => $request->fecha_compra,
            'id_usuario' => Auth::user()->id_usuario,
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
            'usuario' => $compra->usuario ? $compra->usuario->user : 'sin usuario',
            'id_proveedor' => $compra->id_proveedor,
            'proveedor' => $compra->proveedor ? $compra->proveedor->nombre_proveedor : 'sin proveedor'
        ]);
    }

    public function update(Request $request, Compras $compra)
    {
        $request->validate([
            'fecha_compra' => 'required|date',
            'id_proveedor' => 'required|exists:proveedor,id_proveedor'
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
