<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\compras\DetalleCompra;
use App\Models\compras\Compra;
use App\Models\proveedor\Proveedor;

class ComprasController extends Controller
{

    public function index(Request $request, DetalleCompra $id_compra)
    {
        //filtros
        $query = Compra::query();
        //filtro proveedor
        if ($request->filled('proveedorSelect')) {
            $query->whereHas('proveedor', function ($query) use ($request) {
                $query->where('nombre_proveedor', 'like', '%' . $request->proveedorSelect . '%');
            });
        }
        //filtro fechas de compra
        if ($request->filled('fechaInicio') && $request->filled('fechaFin')) {
            $query->whereBetween('fecha_compra', [
                $request->fechaInicio,
                $request->fechaFin
            ]);
        } elseif ($request->filled('fechaInicio')) {
            $query->where('fecha_compra', '>=', $request->fechaInicio);
        } elseif ($request->filled('fechaFin')) {
            $query->where('fecha_compra', '<=', $request->fechaFin);
        }

        //paginación
        $porPagina = $request->input('PorPagina', 10);
        $compras = $query->paginate($porPagina);
        $proveedores = Proveedor::all();
        if ($request->ajax()) {
            return view('admin.compras.layoutcompras.tablacompras', compact('compras', 'proveedores'))->render();
        }

        return view('admin.compras.index', compact('compras', 'proveedores'));
    }

    public function store(Request $request, Compra $compra)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'fecha_compra' => 'required|date',
            'id_proveedor' => 'required|exists:proveedor,id_proveedor'

        ]);
        // Verificar si el proveedor existe
        $compra = Compra::create([
            'fecha_compra' => $request->fecha_compra,
            'id_usuario' => Auth::user()->id_usuario,
            'id_proveedor' => $request->id_proveedor
        ]);
        // Verificar si se han enviado productos
        return redirect()->route('admin.compras.index')->with('message', [
            'type' => 'success',
            'text' => 'La compra se ha creado correctamente.'
        ]);
    }

    public function show(Compra $compra)
    {
        // Retornar los detalles de la compra
        return response()->json([
            'id_compra' => $compra->id_compra,
            'fecha_compra' => $compra->fecha_compra,
            'id_usuario' => $compra->id_usuario,
            'usuario' => $compra->usuario ? $compra->usuario->user : 'sin usuario',
            'id_proveedor' => $compra->id_proveedor,
            'proveedor' => $compra->proveedor ? $compra->proveedor->nombre_proveedor : 'sin proveedor',
            'total_compra' => $compra->total_compra ?? 'sin compras'
        ]);
    }

    public function update(Request $request, Compra $compra)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'fecha_compra' => 'required|date',
            'id_proveedor' => 'required|exists:proveedor,id_proveedor'
        ]);
        // Actualizar los datos de la compra
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
        $compra = Compra::find($id_compra);

        if (!$compra) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'La compra no existe en la base de datos.'
            ]);
        }

        $compra->detalleCompra->each(function ($detalle) {
            $detalle->detalleInventario()->delete();
        });

        $compra->detalleCompra()->delete();

        $compra->delete();

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'La compra y sus detalles han sido eliminados correctamente.'
        ]);
    }
}
