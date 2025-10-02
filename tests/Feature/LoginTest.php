<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\usuarios\User;

class LoginTest extends TestCase
{
    public function test_login_usuario_correcto()
    {
        $user = 'macro';
        $password = 'Alvtururu578!';
        $rol = 1;

        $response = $this->post('/login', [
            'user' => $user,
            'password' => $password,
            'rol' => $rol
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.dashboard'));

        $usuario = User::where('user', $user)->first();
        $this->assertAuthenticatedAs($usuario);
    }
}
