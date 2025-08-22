<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuarios\User;
use Illuminate\Support\Facades\Hash;
use App\Models\usuarios\Rol;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{

    public function index(Request $request)
    {
        $query = User::query();
        // Filtro por documento
        if ($request->filled('buscar_documento')) {
            $documento_usuario = preg_replace('/\D/', '', $request->buscar_documento);
            $query->where('documento_usuario', 'like', $documento_usuario . '%');
        }
        // Filtro por nombre o apellido
        if ($request->filled('buscar_nombre') && strlen(trim($request->buscar_nombre)) >= 3) {
            $termino_busqueda = trim($request->buscar_nombre);

            $query->where(function ($q) use ($termino_busqueda) {
                $q->where('nombre_usuario', 'like', '%' . $termino_busqueda . '%')
                    ->orWhere('apellido_usuario', 'like', '%' . $termino_busqueda . '%');
            });
        }



        // Filtro por rol
        if ($request->filled('rol')) {
            $query->whereHas('rol', function ($query) use ($request) {
                $query->where('nombre_rol', 'like', '%' . $request->rol . '%');
            });
        }

        $porPagina = $request->input('entries', 15);
        $usuarios = $query->paginate($porPagina)->appends($request->query());

        if ($request->ajax()) {
            return view('admin.usuarios.layoutusuarios.tablausuarios', compact('usuarios'))->render();
        }

        $roles = Rol::all();
        return view('admin.usuarios.index', compact('usuarios', 'roles'));
    }

    public function create()
    {
        //
    }
    public function store(Request $request, User $usuario)
    {
        $request->validate([
            'user' => 'required|string|min:5|max:50',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=(?:.*\d){3,})(?=.*[!@#$%^&*()_\-+=\[\]{};:\'",.<>\/?\\|`~]).+$/'
            ],
            'documento_usuario' => 'required|digits_between:6,10',
            'telefono_usuario' => 'required|digits_between:6,10',
            'nombre_usuario' => 'required|string|max:50',
            'apellido_usuario' => 'required|string|max:50',
            'correo_usuario' => 'required|string|email|max:100',
            'id_rol' => 'required|exists:rol,id_rol'
        ]);

        $request->merge([
            'password' => Hash::make($request->password)
        ]);

        $existingUsuario = User::where('documento_usuario', $request->documento_usuario)
            ->where('telefono_usuario', $request->telefono_usuario)
            ->where('correo_usuario', $request->correo_usuario)
            ->where('user', $request->user)
            ->where('id_usuario', '!=', $usuario->id_usuario)
            ->first();

        if ($existingUsuario) {
            return redirect()->route('admin.usuarios.index')->with('message', [
                'type' => 'error',
                'text' => 'El usuario ya existe en la base de datos.'
            ]);
        } else {
            $usuario = User::create($request->all());
            return redirect()->route('admin.usuarios.index')->with('message', [
                'type' => 'success',
                'text' => 'El usuario se ha creado correctamente.'
            ]);
        }
    }
    public function show(User $usuario)
    {
        return response()->json([
            'nombre_usuario' => $usuario->nombre_usuario,
            'apellido_usuario' => $usuario->apellido_usuario,
            'documento_usuario' => $usuario->documento_usuario,
            'telefono_usuario' => $usuario->telefono_usuario,
            'correo_usuario' => $usuario->correo_usuario,
            'user' => $usuario->user,
            'password' => $usuario->password,
            'id_rol' => $usuario->id_rol,
            'nombre_rol' => $usuario->rol ? $usuario->rol->nombre_rol : 'Sin categoría'
        ]);
    }

    public function edit(User $usuario)
    {
        return response()->json([
            'nombre_usuario' => $usuario->nombre_usuario,
            'apellido_usuario' => $usuario->apellido_usuario,
            'documento_usuario' => $usuario->documento_usuario,
            'telefono_usuario' => $usuario->telefono_usuario,
            'correo_usuario' => $usuario->correo_usuario,
            'user' => $usuario->user,
            'password' => $usuario->password,
            'id_rol' => $usuario->id_rol,
            'nombre_rol' => $usuario->rol ? $usuario->rol->nombre_rol : 'Sin categoría'
        ]);
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'user' => 'required|string|min:5|max:50',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'regex:/^(?=.*[A-Z])(?=(?:.*\d){3,})(?=.*[.!@#$%^&*()_\-+=\[\]{};:\'",.<>\/?\\|`~]).+$/'
            ],
            'documento_usuario' => 'required|digits_between:6,10',
            'telefono_usuario' => 'required|digits_between:6,10',
            'nombre_usuario' => 'required|string|max:50',
            'apellido_usuario' => 'required|string|max:50',
            'correo_usuario' => 'required|string|email|max:100',
            'id_rol' => 'required|exists:rol,id_rol'
        ]);

        // Verificar duplicados
        $existingUsuario = User::where('documento_usuario', $request->documento_usuario)
            ->where('telefono_usuario', $request->telefono_usuario)
            ->where('correo_usuario', $request->correo_usuario)
            ->where('user', $request->user)
            ->where('id_usuario', '!=', $usuario->id_usuario)
            ->first();

        if ($existingUsuario) {
            return redirect()->route('admin.usuarios.index')->with('message', [
                'type' => 'error',
                'text' => 'El usuario ya existe en la base de datos.'
            ]);
        }
        
        $usuario->fill($request->except('password'));

        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('admin.usuarios.index')->with('message', [
            'type' => 'success',
            'text' => 'El usuario se ha actualizado correctamente.'
        ]);
    }


    public function destroy(User $usuario)
    {
        // Evitar borrar el usuario autenticado
        if (Auth::User()->id_usuario === $usuario->id_usuario) {
            return redirect()->route('admin.usuarios.index')->with('message', [
                'type' => 'error',
                'text' => 'No puedes eliminar tu propio usuario mientras estás logueado.'
            ]);
        } else {
            $usuario->delete();

            return redirect()->route('admin.usuarios.index')->with('message', [
                'type' => 'success',
                'text' => 'Usuario eliminado correctamente.'
            ]);
        }
    }
}
