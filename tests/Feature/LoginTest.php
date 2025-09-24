<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\usuarios\User;

class LoginTest extends TestCase
{
    public function LoginTest()
    {
        $user = 'macro';
        $password = 'Alvtururu578!';
        $rol = 1;

        // Llamada al login
        $response = $this->post('/login', [
            'user' => $user,
            'password' => $password,
            'rol' => $rol
        ]);

        // Verifica que el login redirige a la ruta esperada
        $response->assertStatus(302); // 302 si tu login redirige
        $response->assertRedirect(route('admin.dashboard')); // Ajusta según tu controlador

        // Verifica que el usuario quedó autenticado
        $usuario = User::where('user', $user)->first();
        $this->assertAuthenticatedAs($usuario);
        
    }
}
