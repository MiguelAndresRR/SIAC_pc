<?php

namespace Tests\Feature;

use App\Models\proveedor\Proveedor;
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

    public function test_crear_proveedor()
    {
        $usuario = $this->loginUsuario();

        $response = $this->post(route('admin.proveedores.store'), [
            'nombre_proveedor' => 'Pichincha',
            'telefono_proveedor' => '3001776690',
            'nit_proveedor' => '9999999999',
            'direccion_proveedor' => 'Cra16 # 66-72 sur',
            'correo_proveedor' => 'pichincha98@gmail.com'
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.proveedores.index'));

        $this->assertDatabaseHas('proveedor', [
            'nombre_proveedor' => 'Pichincha',
        ]);
    }
    public function test_editar_proveedor()
    {
        $usuario = $this->loginUsuario();

        $proveedor = Proveedor::create([
            'nombre_proveedor' => 'Pichincha',
            'telefono_proveedor' => '3001776690',
            'nit_proveedor' => '9999999999',
            'direccion_proveedor' => 'Cra16 # 66-72 sur',
            'correo_proveedor' => 'pichincha98@gmail.com'
        ]);

        $datosNuevos = [
            'nombre_proveedor' => 'Insumos Pichincha',
            'telefono_proveedor' => '3001774497',
            'nit_proveedor' => '9999999000',
            'direccion_proveedor' => 'Cra16 # 66-72 sur',
            'correo_proveedor' => 'pichincha98@gmail.com'
        ];

        $response = $this->put(route('admin.proveedores.update', $proveedor->id_proveedor), $datosNuevos);

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.proveedores.index'));

        $this->assertDatabaseHas('proveedor', [
            'id_proveedor' => $proveedor->id_proveedor,
            'nombre_proveedor' => 'Insumos Pichincha',
            'telefono_proveedor' => '3001774497',
            'nit_proveedor' => '9999999000',
            'direccion_proveedor' => 'Cra16 # 66-72 sur',
            'correo_proveedor' => 'pichincha98@gmail.com'
        ]);
    }
    public function test_eliminar_proveedor()
    {
        $usuario = $this->loginUsuario();

        $proveedor = Proveedor::create([
            'nombre_proveedor' => 'Pichincha',
            'telefono_proveedor' => '3001776690',
            'nit_proveedor' => '9999999999',
            'direccion_proveedor' => 'Cra16 # 66-72 sur',
            'correo_proveedor' => 'pichincha98@gmail.com'
        ]);

        $response = $this->delete(route('admin.proveedores.destroy', $proveedor->id_proveedor));

        $response->assertStatus(302);

        $response->assertRedirect();
        $response->assertSessionHas('message.type', 'success');


        $this->assertDatabaseMissing('proveedor', [
            'id_proveedor' => $proveedor->id_proveedor,
            'nombre_proveedor' => 'Pichincha',
            'telefono_proveedor' => '3001776690',
            'nit_proveedor' => '9999999999',
            'direccion_proveedor' => 'Cra16 # 66-72 sur',
            'correo_proveedor' => 'pichincha98@gmail.com'
        ]);
    }
}
