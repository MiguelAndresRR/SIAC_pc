<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\clientes\Cliente;

class ClientesController extends Controller
{
    //Esta funcion nos permite mostrar todoa los datos, cuenta con condicionales que en el
    //caso de que se utilizen la consulta va a realizarce con esos parametros.
    //Se maneja la paginacion y nos retorna los datos de la consulta con o sin filtros en la tabla y en el index.
    public function index(Request $request)
    {
        $query = Cliente::query();
        if ($request->filled('buscar_nombre_cliente') && strlen(trim($request->buscar_nombre_cliente)) >= 3) {
            $termino_busqueda = trim($request->buscar_nombre_cliente);

            $query->where(function ($q) use ($termino_busqueda) {
                $q->where('nombre_cliente', 'like', '%' . $termino_busqueda . '%')
                    ->orWhere('apellido_cliente', 'like', '%' . $termino_busqueda . '%');
            });
        }
        if ($request->filled('buscar_documento_cliente')) {
            $documento = preg_replace('/\D/', '', $request->buscar_documento_cliente);

            $query->where('documento_cliente', 'like', $documento . '%');
        }
        $porPagina = $request->input('PorPagina', 10); // 10 por defecto
        $clientes = $query->paginate($porPagina);
        if ($request->ajax()) {
            return view('admin.clientes.layoutclientes.tablaclientes', compact('clientes'))->render();
        }

        return view('admin.clientes.index', compact('clientes', 'porPagina'));
    }

    //se encarga de guardar los campos del formulario en la base de datos, valida los datos enviados, 
    //verifica que estos datos no coincidan con otro cliente y los guarda.
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
        $nombre = ucwords(strtolower($request->nombre_cliente));
        $apellido = ucwords(strtolower($request->apellido_cliente));
        if ($existingCliente) {
            return redirect()->route('admin.clientes.index')->with('message', [
                'type' => 'error',
                'text' => 'El cliente ya existe en la base de datos.'
            ]);
        } else {
            $cliente = Cliente::create([
                'nombre_cliente' => $nombre,
                'apellido_cliente' => $apellido,
                'documento_cliente' => $request->documento_cliente,
                'telefono_cliente' => $request->telefono_cliente,
                'correo_cliente' => $request->correo_cliente,
            ]);
            return redirect()->route('admin.clientes.index')->with('message', [
                'type' => 'success',
                'text' => 'El cliente se ha creado correctamente.'
            ]);
        }
    }

    // esta funcion la usamos para el edit y para el show, que nos permite llamar los datos.
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

    //Es igual que el store, valida que no se repitan los clientes y actualiza el mismo registro.
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
        $nombre = ucwords(strtolower($request->nombre_cliente));
        $apellido = ucwords(strtolower($request->apellido_cliente));
        if ($existingCliente) {
            return redirect()->route('admin.clientes.index')->with('message', [
                'type' => 'error',
                'text' => 'El cliente ya existe en la base de datos.'
            ]);
        } else {
            $cliente->nombre_cliente = $nombre;
            $cliente->apellido_cliente = $apellido;
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

    //Esta funcion nos permite borrar clientes, pero en caso de que este tenga compras asociadas 
    // no se podra borrar para mantener la trazabilidad. 
    public function destroy($id_cliente)
    {
        $cliente = Cliente::find($id_cliente);

        if (!$cliente) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'El cliente no existe en la base de datos.'
            ]);
        }

        // Verificar si tiene ventas
        if ($cliente->ventas()->exists()) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'No se puede eliminar el cliente porque tiene ventas registradas.'
            ]);
        }

        $cliente->delete();

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'El cliente se ha eliminado correctamente.'
        ]);
    }
}
