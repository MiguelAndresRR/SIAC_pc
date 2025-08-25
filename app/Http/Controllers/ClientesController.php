<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\clientes\Cliente;

class ClientesController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();
        // if ($request->filled('buscar_productos') && strlen(trim($request->buscar_productos)) >= 3) {
        //     $palabras = explode(' ', $request->buscar_productos);

        //     $query->where(function ($q) use ($palabras) {
        //         foreach ($palabras as $palabra) {
        //             $q->where('nombre_producto', 'like', '%' . $palabra . '%');
        //         }
        //     });
        // }

        $porPagina = $request->input('PorPagina', 10); // 10 por defecto
        $clientes = $query->paginate($porPagina);
        if ($request->ajax()) {
            return view('admin.clientes.layoutclientes.tablaclientes', compact('clientes'))->render();
        }

        return view('admin.clientes.index', compact('clientes', 'porPagina'));
    }
    public function store(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre_cliente' => 'required|string|max:50',
            'apellido_cliente' => 'required|string|max:50',
            'documento_cliente' => 'required|digits_between:6,10',
            'telefono_cliente' => 'required|digits_between:6,10',
            'direccion_cliente' => 'required|string|min:5|max:50',
            'correo_cliente' => 'required|string|email|max:100'

        ]);

        $existingCliente = Cliente::where('nombre_cliente', $request->nombre_cliente)
            ->where('apellido_cliente', $request->apellido_cliente)
            ->where('documento_cliente', $request->documento_cliente)
            ->where('telefono_cliente', $request->telefono_cliente)
            ->where('correo_cliente', $request->correo_cliente)
            ->first();

        if ($existingCliente) {
            return redirect()->route('admin.clientes.index')->with('message', [
                'type' => 'error',
                'text' => 'El cliente ya existe en la base de datos.'
            ]);
        } else {
            $cliente = Cliente::create($request->all());
            return redirect()->route('admin.clientes.index')->with('message', [
                'type' => 'success',
                'text' => 'El cliente se ha creado correctamente.'
            ]);
        }
    }
    public function show(Cliente $cliente)
    {
        return response()->json([
            'nombre_cliente' => $cliente->nombre_cliente,
            'apellido_cliente' => $cliente->apellido_cliente,
            'documento_cliente' => $cliente->documento_cliente,
            'telefono_cliente' => $cliente->telefono_cliente,
            'direccion_cliente' => $cliente->direccion_cliente,
            'correo_cliente' => $cliente->correo_cliente
        ]);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $request->validate([
            'nombre_cliente' => 'required|string|max:50',
            'apellido_cliente' => 'required|string|max:50',
            'documento_cliente' => 'required|digits_between:6,10',
            'telefono_cliente' => 'required|digits_between:6,10',
            'direccion_cliente' => 'required|string|min:5|max:50',
            'correo_cliente' => 'required|string|email|max:100'

        ]);

        $existingCliente = Cliente::where('nombre_cliente', $request->nombre_cliente)
            ->where('apellido_cliente', $request->apellido_cliente)
            ->where('documento_cliente', $request->documento_cliente)
            ->where('telefono_cliente', $request->telefono_cliente)
            ->where('correo_cliente', $request->correo_cliente)
            ->where('id_cliente', '!=', $cliente->id_cliente)
            ->first();

        if ($existingCliente) {
            return redirect()->route('admin.clientes.index')->with('message', [
                'type' => 'error',
                'text' => 'El cliente ya existe en la base de datos.'
            ]);
        } else {
            $cliente->nombre_cliente = $request->nombre_cliente;
            $cliente->apellido_cliente = $request->apellido_cliente;
            $cliente->documento_cliente = $request->documento_cliente;
            $cliente->telefono_cliente = $request->telefono_cliente;
            $cliente->direccion_cliente = $request->direccion_cliente;
            $cliente->correo_cliente = $request->correo_cliente;
            $cliente->save();
            return redirect()->route('admin.clientes.index')->with('message', [
                'type' => 'success',
                'text' => 'El cliente se ha actualizado correctamente.'
            ]);
        }
    }

    public function destroy($id_cliente)
    {
        $cliente = Cliente::find($id_cliente);
        if (!$cliente) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'El cliente no existe en la base de datos.'
            ]);
        }

        $cliente->delete();
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'El cliente se ha eliminado correctamente.'
        ]);
    }
}
