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

        $producto = Producto::create([
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
            'id_producto' => $producto->id_producto,
            'nombre_producto' => 'Semilla Papaya',
            'precio_producto' => 1500,
            'id_categoria_producto' => 1,
            'id_unidad_peso_producto' => 1
        ]);
    }
    public function test_eliminar_producto()
    {
        $usuario = $this->loginUsuario();

        $producto = Producto::create([
            'nombre_producto' => 'Semilla Aguacate',
            'precio_producto' => 2500,
            'id_categoria_producto' => 1,
            'id_unidad_peso_producto' => 1
        ]);

        $response = $this->delete(route('admin.productos.destroy', $producto->id_producto));

        $response->assertStatus(302);

        $response->assertRedirect();
        $response->assertSessionHas('message.type', 'success');


        $this->assertDatabaseMissing('producto', [
            'id_producto' => $producto->id_producto,
            'nombre_producto' => 'Semilla Aguacate',
            'precio_producto' => 2500,
            'id_categoria_producto' => 1,
            'id_unidad_peso_producto' => 1
        ]);
    }

    public function test_sistema_soporta_varias_consultas_seguidas()
    {
        $usuario = $this->loginUsuario();
        $start = microtime(true);

        for ($i = 0; $i < 100; $i++) {
            $response = $this->actingAs($usuario)->get(route('admin.productos.index'));
            $response->assertStatus(200);
        }

        $duration = microtime(true) - $start;

        // Ejemplo: esperamos que 100 consultas no tarden más de 10 segundos
        $this->assertLessThan(10, $duration, "Las 100 consultas fueron demasiado lentas");
    }
    public function test_informe_se_genera_menos_de_5_segundos()
    {
        $usuario = $this->loginUsuario();

        // Solo unos pocos registros para el test
        Producto::factory()->count(50)->create();

        ini_set('memory_limit', '1024M'); // evitar errores de memoria en test

        $start = microtime(true);

        $response = $this->actingAs($usuario)
            ->get(route('admin.reportes.productos_pdf'));

        $duration = microtime(true) - $start;

        $response->assertStatus(200);
        $this->assertLessThan(5, $duration, "El informe tardó más de 5 segundos");
    }
}
