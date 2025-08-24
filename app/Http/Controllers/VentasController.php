<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ventas\Venta;
use Illuminate\Support\Facades\Auth;
use App\Models\clientes\Cliente;
use App\Models\usuarios\User;

class VentasController extends Controller
{
        public function index(Request $request, Venta $id_venta)
    {
        //filtros
        $query = Venta::query();
        //filtro proveedor
        // if ($request->filled('proveedorSelect')) {
        //     $query->whereHas('proveedor', function ($query) use ($request) {
        //         $query->where('nombre_proveedor', 'like', '%' . $request->proveedorSelect . '%');
        //     });
        // }
        //filtro fechas de compra
        // if ($request->filled('fechaInicio') && $request->filled('fechaFin')) {
        //     $query->whereBetween('fecha_compra', [
        //         $request->fechaInicio,
        //         $request->fechaFin
        //     ]);
        // } elseif ($request->filled('fechaInicio')) {
        //     $query->where('fecha_compra', '>=', $request->fechaInicio);
        // } elseif ($request->filled('fechaFin')) {
        //     $query->where('fecha_compra', '<=', $request->fechaFin);
        // }

        //paginación
        $porPagina = $request->input('PorPagina', 10);
        $ventas = $query->paginate($porPagina);
        if ($request->ajax()) {
            return view('admin.ventas.layoutventas.tablaventas', compact('ventas'))->render();
        }

        return view('admin.ventas.index', compact('ventas'));
    }

    public function store(Request $request, Venta $venta)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'id_cliente' => 'required|exists:cliente,id_cliente',
            'fecha_venta' => 'required|date',
            'id_usuario' => 'required|exists:usuario,id_usuario',
        ]);

        $venta = Venta::create([
            'id_cliente' => $request->id_cliente,
            'fecha_compra' => $request->fecha_compra,
            'id_usuario' => Auth::user()->id_usuario,
        ]);
        // Verificar si se han enviado productos
        return redirect()->route('admin.venta.index')->with('message', [
            'type' => 'success',
            'text' => 'La venta se ha creado correctamente.'
        ]);
    }

    public function show(Venta $venta)
    {
        // Retornar los detalles de la compra
        return response()->json([
            'id_venta' => $venta->id_venta,
            'fecha_venta' => $venta->fecha_venta,
            'id_usuario' => $venta->id_usuario,
            'usuario' => $venta->usuario ? $venta->usuario->user : 'sin usuario',
            'id_cliente' => $venta->id_cliente,
            'cliente' => $venta->id_cliente ? $venta->id_cliente->nombre_cliente : 'sin cliente',
            'total_venta' => $venta->total_venta ?? 'sin ventas'
        ]);
    }

    public function update(Request $request, Venta $venta)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'id_cliente' => 'required|exists:cliente,id_cliente',
            'fecha_venta' => 'required|date',
            'id_usuario' => 'required|exists:usuario,id_usuario',
        ]);
        // Actualizar los datos de la venta
        $venta->fecha_venta = $request->fecha_venta;
        $venta->id_cliente = $request->id_cliente;
        $venta->save();
        return redirect()->route('admin.ventas.index')->with('message', [
            'type' => 'success',
            'text' => 'La venta se ha actualizado correctamente'
        ]);
    }

    public function destroy($id_venta)
    {
        // Eliminar la venta
        $venta = Venta::find($id_venta);
        if (! $id_venta) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'LA venta no existe en la base de datos.'
            ]);
        }
        // Verificar si la compra tiene detalles asociados y eliminarlos
        $venta->detalleVenta()->delete();
        $venta->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'La venta y sus detalles han sido eliminados correctamente.'
        ]);
    }
}
