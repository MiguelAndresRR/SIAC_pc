<?php

namespace Tests\Helpers;

use App\Models\usuarios\User;

trait LoginHelper
{
    public function loginUsuario($user = 'macro', $password = 'Alvtururu578!', $rol = 1)
    {
        $response = $this->post('/login', [
            'user' => $user,
            'password' => $password,
            'rol' => $rol,
        ]);

        $usuario = User::where('user', $user)->first();
        $this->assertAuthenticatedAs($usuario);

        return $usuario;
    }
}
