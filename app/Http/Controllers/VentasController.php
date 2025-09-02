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
        //filtro cliente
        if ($request->filled('clienteSelect')) {
            $query->whereHas('cliente', function ($query) use ($request) {
                $query->where('id_cliente', 'like', '%' . $request->clienteSelect . '%');
            });
        }
        //filtro fechas de compra
        if ($request->filled('fechaInicio') && $request->filled('fechaFin')) {
            $query->whereBetween('fecha_venta', [
                $request->fechaInicio,
                $request->fechaFin
            ]);
        } elseif ($request->filled('fechaInicio')) {
            $query->where('fecha_venta', '>=', $request->fechaInicio);
        } elseif ($request->filled('fechaFin')) {
            $query->where('fecha_venta', '<=', $request->fechaFin);
        }

        //paginación
        $usuarios = User::All();
        $clientes = Cliente::All();
        $porPagina = $request->input('PorPagina', 10);
        $ventas = $query->paginate($porPagina);
        if ($request->ajax()) {
            return view('admin.ventas.layoutventas.tablaventas', compact('ventas', 'clientes', 'usuarios'))->render();
        }

        return view('admin.ventas.index', compact('ventas', 'clientes', 'usuarios'));
    }

    public function store(Request $request, Venta $venta)
    {
        // Validar los datos de la solicitud
        $request->validate([
            'id_cliente' => 'required|exists:cliente,id_cliente',
            'fecha_venta' => 'required|date'
        ]);

        $venta = Venta::create([
            'id_cliente' => $request->id_cliente,
            'fecha_venta' => $request->fecha_venta,
            'id_usuario' => Auth::user()->id_usuario,
        ]);
        // Verificar si se han enviado productos
        return redirect()->route('admin.ventas.index')->with('message', [
            'type' => 'success',
            'text' => 'La venta se ha creado correctamente.'
        ]);
    }

    public function show(Venta $venta)
    {
        return response()->json([
            'id_venta' => $venta->id_venta,
            'id_cliente' => $venta->id_cliente,
            'id_usuario' => $venta->id_usuario,
            'usuario' => $venta->usuario ? $venta->usuario->user : 'sin usuario',
            'fecha_venta' => $venta->fecha_venta
        ]);
    }


    public function update(Request $request, Venta $venta)
    {
        // Validar los datos de la solicitud

        $request->validate([
            'id_cliente' => 'required|exists:cliente,id_cliente',
            'fecha_venta' => 'required|date'
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
        $venta = Venta::find($id_venta);

        if (!$venta) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'La venta no existe en la base de datos.'
            ]);
        }

        // Verificar si algún detalle de la venta tiene registros asociados (por ejemplo, devoluciones o stock movido)
        $tieneDetallesAsociados = $venta->detalleVenta()->exists();

        if ($tieneDetallesAsociados) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'No se puede eliminar la venta porque tiene detalles registrados.'
            ]);
        }

        // Si no tiene detalles, eliminar la venta
        $venta->delete();

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'La venta ha sido eliminada correctamente.'
        ]);
    }
}
