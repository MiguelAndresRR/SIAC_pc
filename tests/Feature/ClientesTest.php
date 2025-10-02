<?php

namespace Tests\Feature;

use App\Models\clientes\Cliente;
use GuzzleHttp\Client;
use Tests\Helpers\LoginHelper;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

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

    public function test_crear_cliente()
    {
        $usuario = $this->loginUsuario();

        $response = $this->post(route('admin.clientes.store'), [
            'nombre_cliente' => 'Publico',
            'apellido_cliente' => 'General',
            'documento_cliente' => '102234509',
            'telefono_cliente' => '3005560224',
            'direccion_cliente' => 'No aplica',
            'correo_cliente' => 'semilleros@gmail.com'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.clientes.index'));

        $this->assertDatabaseHas('cliente', [
            'nombre_cliente' => 'Publico',
        ]);
    }
    public function test_editar_cliente()
    {
        $usuario = $this->loginUsuario();

        $cliente = Cliente::create([
            'nombre_cliente' => 'Publico',
            'apellido_cliente' => 'General',
            'documento_cliente' => '102234509',
            'telefono_cliente' => '3005560224',
            'direccion_cliente' => 'No aplica',
            'correo_cliente' => 'semilleros@gmail.com'
        ]);

        $datosNuevos = [
            'nombre_cliente' => 'Publico',
            'apellido_cliente' => 'General',
            'documento_cliente' => '9999999900',
            'telefono_cliente' => '3004460224',
            'direccion_cliente' => 'No aplica',
            'correo_cliente' => 'semilleros@gmail.com'
        ];

        $response = $this->put(route('admin.clientes.update', $cliente->id_cliente), $datosNuevos);

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.clientes.index'));

        $this->assertDatabaseHas('cliente', [
            'id_cliente' => $cliente->id_cliente,
            'nombre_cliente' => 'Publico',
            'apellido_cliente' => 'General',
            'documento_cliente' => '9999999900',
            'telefono_cliente' => '3004460224',
            'direccion_cliente' => 'No aplica',
            'correo_cliente' => 'semilleros@gmail.com'
        ]);
    }
    public function test_eliminar_cliente()
    {
        $usuario = $this->loginUsuario();

        $cliente = Cliente::create([
            'nombre_cliente' => 'Publico',
            'apellido_cliente' => 'General',
            'documento_cliente' => '102234509',
            'telefono_cliente' => '3005560224',
            'direccion_cliente' => 'No aplica',
            'correo_cliente' => 'semilleros@gmail.com'
        ]);

        $response = $this->delete(route('admin.clientes.destroy', $cliente->id_cliente));

        $response->assertStatus(302);

        $response->assertRedirect();
        $response->assertSessionHas('message.type', 'success');


        $this->assertDatabaseMissing('cliente', [
            'nombre_cliente' => 'Publico',
            'apellido_cliente' => 'General',
            'documento_cliente' => '102234509',
            'telefono_cliente' => '3005560224',
            'direccion_cliente' => 'No aplica',
            'correo_cliente' => 'semilleros@gmail.com'
        ]);
    }
}
