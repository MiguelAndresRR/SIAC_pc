<?php

namespace Tests\Feature;

use App\Http\Controllers\ProductoController;
use App\Models\productos\Producto;
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

    public function test_crear_producto()
    {
        $usuario = $this->loginUsuario();

        $response = $this->post(route('admin.productos.store'), [
            'nombre_producto' => 'Semilla Aguacate',
            'precio_producto' => '2500',
            'id_categoria_producto' => 1,
            'id_unidad_peso_producto' => 1
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.productos.index'));

        $this->assertDatabaseHas('producto', [
            'nombre_producto' => 'Semilla Aguacate',     
        ]);
    }
    public function test_editar_producto()
    {
        $usuario = $this->loginUsuario();

        $producto = Producto::factory()->create([
            'nombre_producto' => 'Semilla Aguacate',
            'precio_producto' => '2500',
            'id_categoria_producto' => 1,
            'id_unidad_peso_producto' => 1
        ]);

        $datosNuevos = [
            'nombre_producto' => 'Semilla Papaya',
            'precio_producto' => '1500',
            'id_categoria_producto' => 1,
            'id_unidad_peso_producto' => 1
        ];

        $response = $this->put(route('admin.productos.update', $producto->id_producto), $datosNuevos);

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.productos.index'));

        $this->assertDatabaseHas('producto', [
            'id' => $producto->id_producto,
            'nombre_producto' => 'Semilla Papaya',
            'precio_producto' => 1500,
        ]);
    }
}
