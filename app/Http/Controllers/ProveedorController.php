<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\proveedor\Proveedor;
use Illuminate\Support\Facades\Auth;
class ProveedorController extends Controller
{
    //Nos trae todos los productos registrados de datos, 
    //si se utilizan los filtros la tabla de la vista se actualiza con la nueva consulta.
    public function index(Request $request)
    {
        $query = Proveedor::query();

        if ($request->filled('buscar_proveedor') && strlen(trim($request->buscar_proveedor)) >= 3) {
            $palabras = explode(' ', $request->buscar_proveedor);

            $query->where(function ($q) use ($palabras) {
                foreach ($palabras as $palabra) {
                    $q->where('nombre_proveedor', 'like', '%' . $palabra . '%');
                }
            });
        }

        if ($request->filled('nit_proveedor')) {
            $nit = preg_replace('/\D/', '', $request->nit_proveedor);

            $query->where('nit_proveedor', 'like', $nit . '%');
        }


        $porPagina = $request->input('entries', 15);
        $proveedores = $query->paginate($porPagina)->appends($request->query());
        $user = Auth::user();
        if ($user->id_rol == 1) {
            if ($request->ajax()) {
                return view('admin.proveedores.layoutproveedores.tablaproveedores', compact('proveedores'))->render();
            }

            return view('admin.proveedores.index', compact('proveedores'));
        } elseif ($user->id_rol == 2) {
            if ($request->ajax()) {
                return view('user.proveedores.layoutproveedores.tablaproveedores', compact('proveedores'))->render();
            }

            return view('user.proveedores.index', compact('proveedores'));
        }
    }

    //Registra en la base de datos el registro del formulario enviado de crear proveedores
    //Verifica que no exista el proveedor antes de crearlo.
    public function store(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string|min:5|max:50',
            'nit_proveedor' => 'required|digits_between:6,10',
            'direccion_proveedor' => 'required|string|min:5|max:50',
            'telefono_proveedor' => 'required|digits_between:6,10',
            'correo_proveedor' => 'required|string|email|max:100'
        ]);
        $nombre = ucwords(strtolower($request->nombre_proveedor));
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
            $proveedor = Proveedor::create([
                'nombre_proveedor' => $nombre,
                'nit_proveedor' => $request->nit_proveedor,
                'direccion_proveedor' => $request->direccion_proveedor,
                'telefono_proveedor' => $request->telefono_proveedor,
                'correo_proveedor' => $request->correo_proveedor
            ]);


            return redirect()->route('admin.proveedores.index')->with('message', [
                'type' => 'success',
                'text' => 'El proveedor se ha creado correctamente.'
            ]);
        }
    }

    //Trae todos los datos para el show y para el formulario para editar.
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

    //Nos permite actualizar el registro del proveedor seleccionado, valida los request y
    //verifica que no exista el proveedor.
    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre_proveedor' => 'required|string|min:5|max:50',
            'nit_proveedor' => 'required|digits_between:6,10',
            'direccion_proveedor' => 'required|string|min:5|max:50',
            'telefono_proveedor' => 'required|digits_between:6,10',
            'correo_proveedor' => 'required|string|email|max:100'
        ]);
        $nombre = ucwords(strtolower($request->nombre_proveedor));

        $existingProveedor = Proveedor::where(function ($query) use ($request) {
            $query->where('nit_proveedor', $request->nit_proveedor)
                ->orWhere('nombre_proveedor', $request->nombre_proveedor);
        })
            ->where('id_proveedor', '!=', $proveedor->id_proveedor)
            ->first();


        if ($existingProveedor) {
            return redirect()->route('admin.proveedores.index')->with('message', [
                'type' => 'error',
                'text' => 'El proveedor ya existe en la base de datos.'
            ]);
        } else {
            $proveedor->nombre_proveedor = $nombre;
            $proveedor->telefono_proveedor = $request->telefono_proveedor;
            $proveedor->nit_proveedor = $request->nit_proveedor;
            $proveedor->direccion_proveedor = $request->direccion_proveedor;
            $proveedor->correo_proveedor = $request->correo_proveedor;
            $proveedor->save();

            return redirect()->route('admin.proveedores.index')->with('message', [
                'type' => 'success',
                'text' => 'El proveedor se ha actualizado correctamente.'
            ]);
        }
    }

    //Nos permite borrar el registro seleccionado, en caso de que tenga compras
    //asociadas no nos permite borrar el registro.
    public function destroy($id_proveedor)
    {
        $proveedor = Proveedor::find($id_proveedor);

        if (!$proveedor) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'El proveedor no existe en la base de datos.'
            ]);
        }

        // Verificar si tiene compras
        if ($proveedor->compras()->exists()) {
            return redirect()->back()->with('message', [
                'type' => 'error',
                'text' => 'No se puede eliminar el proveedor porque tiene compras registradas.'
            ]);
        }

        $proveedor->delete();

        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'El proveedor se ha eliminado correctamente.'
        ]);
    }
}
