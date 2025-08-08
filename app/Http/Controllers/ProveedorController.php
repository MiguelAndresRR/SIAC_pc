<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\proveedor\Proveedor;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $query = Proveedor::query();

        if ($request->filled('buscar_proveedor')) {
            $query->where('nombre_proveedor', 'like', '%' . $request->buscar_proveedor . '%');
        }

        if ($request->filled('nit_proveedor')) {
            $query->where('nit_proveedor', 'like', '%' . $request->nit_proveedor . '%');
        }

        $porPagina = $request->input('entries', 15);
        $proveedores = $query->paginate($porPagina)->appends($request->query());

        if ($request->ajax()) {
            return view('admin.proveedores.layoutproveedores.tablaproveedores', compact('proveedores'))->render();
        }

        return view('admin.proveedores.index', compact('proveedores'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string|min:5|max:50',
            'nit_proveedor' => 'required|digits_between:6,10',
            'direccion_proveedor' => 'required|string|min:5|max:50',
            'telefono_proveedor' => 'required|digits_between:6,10',
            'correo_proveedor' => 'required|string|email|max:100'
        ]);

        // Verificar si ya existe un proveedor con el mismo NIT o nombre
        $existingProveedor = Proveedor::where('nit_proveedor', $request->nit_proveedor)
            ->orWhere('nombre_proveedor', $request->nombre_proveedor)
            ->first();

        if ($existingProveedor) {
            return redirect()->route('admin.proveedores.index')->with('message', [
                'type' => 'error',
                'text' => 'El proveedor ya existe en la base de datos.'
            ]);
        } else {
            Proveedor::create($request->all());
            return redirect()->route('admin.proveedores.index')->with('message', [
                'type' => 'success',
                'text' => 'El proveedor se ha creado correctamente.'
            ]);
        }
    }
    public function show(Proveedor $proveedor)
    {
        return response()->json([
            'nombre_proveedor' => $proveedor->nombre_proveedor,
            'nit_proveedor' => $proveedor->nit_proveedor,
            'direccion_proveedor' => $proveedor->direccion_proveedor,
            'telefono_proveedor' => $proveedor->telefono_proveedor,
            'correo_proveedor' => $proveedor->correo_proveedor
        ]);
    }

    public function edit(Proveedor $proveedor)
    {
        return response()->json([
            'nombre_proveedor' => $proveedor->nombre_proveedor,
            'nit_proveedor' => $proveedor->nit_proveedor,
            'direccion_proveedor' => $proveedor->direccion_proveedor,
            'telefono_proveedor' => $proveedor->telefono_proveedor,
            'correo_proveedor' => $proveedor->correo_proveedor
        ]);
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string|min:5|max:50',
            'nit_proveedor' => 'required|digits_between:6,10',
            'direccion_proveedor' => 'required|string|min:5|max:50',
            'telefono_proveedor' => 'required|digits_between:6,10',
            'correo_proveedor' => 'required|string|email|max:100'
        ]);


        $existingProveedor = Proveedor::where('id_proveedor', $request->id_proveedor)
            ->where('nombre_proveedor', $request->nombre_proveedor)
            ->where('nit_proveedor', $request->nit_proveedor)
            ->where('direccion_proveedor', $request->direccion_proveedor)
            ->where('telefono_proveedor', $request->telefono_proveedor)
            ->where('correo_proveedor', $request->correo_proveedor)
            ->first();

        if ($existingProveedor) {
            return redirect()->route('admin.proveedores.index')->with('message', [
                'type' => 'error',
                'text' => 'El proveedor ya existe en la base de datos.'
            ]);
        } else {
            $proveedor->nombre_proveedor = $request->nombre_proveedor;
            $proveedor->nit_proveedor = $request->nit_proveedor;
            $proveedor->direccion_proveedor = $request->direccion_proveedor;
            $proveedor->telefono_proveedor = $request->telefono_proveedor;
            $proveedor->correo_proveedor = $request->correo_proveedor;
            $proveedor->save();

            return redirect()->route('admin.proveedores.index')->with('message', [
                'type' => 'success',
                'text' => 'El proveedor se ha actualizado correctamente.'
            ]);
        }
    }

    public function destroy($id_proveedor)
    {
        $proveedor = Proveedor::find($id_proveedor);
        if (!$proveedor) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'El proveedor no existe en la base de datos.'
            ]);
        }

        $proveedor->delete();

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'El proveedor se ha eliminado correctamente.'
        ]);
    }
}
