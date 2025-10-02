<?php

namespace Tests\Feature;

use App\Models\usuarios\User;
use Tests\Helpers\LoginHelper;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;

class ProductoTest extends TestCase
{
    use LoginHelper;

    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }

    public function test_crear_usuario()
    {
        // Simular login de un usuario con permisos
        $usuario = $this->loginUsuario();

        $response = $this->post(route('admin.usuarios.store'), [
            'user' => 'palacios578',
            'password' => 'Alvtu578!',
            'id_rol' => 1,
            'documento_usuario' => '10330753',
            'telefono_usuario' => '30017722',
            'nombre_usuario' => 'miguel felipe',
            'apellido_usuario' => 'camilo',
            'correo_usuario' => 'macroXD678@gmail.com'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.usuarios.index'));
        $usuarios = User::where('user', 'palacios578')->first();
        $this->assertTrue(Hash::check('Alvtu578!', $usuarios->password));
        $this->assertDatabaseHas('usuario', [
            'user' => 'palacios578',
            'id_rol' => 1,
            'documento_usuario' => '10330753',
            'telefono_usuario' => '30017722',
            'nombre_usuario' => 'miguel felipe',
            'apellido_usuario' => 'camilo',
            'correo_usuario' => 'macroXD678@gmail.com'
        ]);
    }
    public function test_editar_proveedor()
    {
        $usuario = $this->loginUsuario();

        $usuarios = User::create([
            'user' => 'palacios578',
            'password' => bcrypt('Alvtururu578!'),
            'id_rol' => 1,
            'documento_usuario' => '1033077753',
            'telefono_usuario' => '3001775022',
            'nombre_usuario' => 'Miguel Felipe',
            'apellido_usuario' => 'Camilo',
            'correo_usuario' => 'macroxd578@gmail.com',
        ]);

        $datosNuevos = [
            'user' => 'palacios777',
            'id_rol' => 1,
            'documento_usuario' => '1033088853',
            'telefono_usuario' => '3001775088',
            'nombre_usuario' => 'Miguel',
            'apellido_usuario' => 'Camilo',
            'correo_usuario' => 'macroxD578@gmail.com',
        ];

        $response = $this->put(route('admin.usuarios.update', $usuarios->id_usuario), $datosNuevos);


        $response->assertStatus(302);

        $response->assertRedirect(route('admin.usuarios.index'));

        $this->assertDatabaseHas('usuario', [
            'id_usuario' => $usuarios->id_usuario,
            'user' => 'palacios777',
            'id_rol' => 1,
            'documento_usuario' => '1033088853',
            'telefono_usuario' => '3001775088',
            'nombre_usuario' => 'Miguel',
            'apellido_usuario' => 'Camilo',
            'correo_usuario' => 'macroxD578@gmail.com',
        ]);
    }

    public function test_eliminar_proveedor()
    {
        $usuario = $this->loginUsuario();

        $usuarios = User::create([
            'user' => 'palacios578',
            'password' => bcrypt('Alvtururu578!'),
            'id_rol' => 1,
            'documento_usuario' => '1033077753',
            'telefono_usuario' => '3001775022',
            'nombre_usuario' => 'Miguel Felipe',
            'apellido_usuario' => 'Camilo',
            'correo_usuario' => 'macroxd578@gmail.com',
        ]);

        $response = $this->delete(route('admin.usuarios.destroy', $usuarios->id_usuario));

        $response->assertStatus(302);

        $response->assertRedirect();
        $response->assertSessionHas('message.type', 'success');


        $this->assertDatabaseMissing('usuario', [
            'id_usuario' => $usuarios->id_usuario,
            'user' => 'palacios578',
            'id_rol' => 1,
            'documento_usuario' => '1033077753',
            'telefono_usuario' => '3001775022',
            'nombre_usuario' => 'Miguel Felipe',
            'apellido_usuario' => 'Camilo',
            'correo_usuario' => 'macroxd578@gmail.com',
        ]);
    }
}
