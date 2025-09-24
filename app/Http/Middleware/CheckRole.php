<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        // Convertir ambos a enteros para asegurar comparación correcta
        $roles = array_map('intval', $roles);

        if (!$user || !in_array((int)$user->id_rol, $roles)) {
            // Si no tiene el rol permitido, redirigir
            if ($user && (int)$user->id_rol === 2) {
                return redirect()->route('user.dashboard')->with('error', 'No tienes permisos.');
            }
            return redirect()->route('login')->with('error', 'No tienes permisos.');
        }

        return $next($request);
    }
}
