<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\usuarios\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    //Valida que el usuario si el usuario no esta logeado
    //con un rol nos retorna a la vista de login para logearnos
    public function showLogin()
    {
        if (Auth::check()) {
            if (Auth::user()->id_rol == 1) {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->id_rol == 2) {
                return redirect()->route('user.dashboard');
            }
        }
        return view('login.login');
    }

    //Recibe los datos de post, verifica primero el usuario, luego la contraseña y 
    //valida que el usuario corresponda con el id del rol.
    public function login(Request $request)
    {
        $data = $request->validate([
            'user'     => 'required|string',
            'password' => 'required|string',
            'rol'      => 'required|integer|exists:rol,id_rol'
        ]);

        $user = User::where('user', $data['user'])
            ->where('id_rol', $data['rol'])
            ->first();

        if ($user && Hash::check($data['password'], $user->password)) {
            Auth::login($user);
            if ($user->id_rol == 1) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->id_rol == 2) {
                return redirect()->route('user.dashboard');
            }
        }
        return back()
            ->withErrors(['login_error' => 'Usuario, contraseña o rol incorrectos.'])
            ->withInput();
    }
    //Esta funcion hace que cuando el usuario le de al boton de cerrar sesion, invalida la session y 
    //regenra el token, nos termina retornando al login.
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
