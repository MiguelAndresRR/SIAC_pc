<?php

namespace Tests\Feature;

use App\Models\compras\Compra;
use App\Models\compras\DetalleCompra;
use App\Models\inventario\DetalleInventario;
use Tests\Helpers\LoginHelper;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ComprasTest extends TestCase
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

    public function test_crear_compra()
    {
        $usuario = $this->loginUsuario();

        $response = $this->post(route('admin.compras.store'), [
            'id_proveedor' => 1,
            'fecha_compra' => '2024-06-20',
            'id_usuario' => 1,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.compras.index'));
    }
    public function test_editar_compra()
    {
        $usuario = $this->loginUsuario();

        $compra = Compra::create([
            'id_proveedor' => 1,
            'fecha_compra' => '2024-06-20',
            'id_usuario' => 1,
        ]);

        $datosNuevos = [
            'id_proveedor' => 1,
            'fecha_compra' => '2024-06-10',
            'id_usuario' => 1,
        ];

        $response = $this->put(route('admin.compras.update', $compra->id_compra), $datosNuevos);

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.compras.index'));

        $this->assertDatabaseHas('compra', [
            'id_compra' => $compra->id_compra,
            'id_proveedor' => 1,
            'fecha_compra' => '2024-06-10',
            'id_usuario' => 1,

        ]);
    }
    public function test_eliminar_compra()
    {
        $usuario = $this->loginUsuario();

        $compras = Compra::create([
            'id_proveedor' => 1,
            'fecha_compra' => '2024-06-20',
            'id_usuario' => 1,
        ]);

        $response = $this->delete(route('admin.compras.destroy', $compras->id_compra));

        $response->assertStatus(302);

        $response->assertRedirect();
        $response->assertSessionHas('message.type', 'success');


        $this->assertDatabaseMissing('compra', [
            'id_compra' => $compras->id_comprar,
            'id_proveedor' => 1,
            'fecha_compra' => '2024-06-20',
            'id_usuario' => 1,
        ]);
    }
    public function test_crear_DetalleCompra()
    {
        $usuario = $this->loginUsuario();

        $compra = Compra::create([
            'id_proveedor' => 1,
            'fecha_compra' => '2024-06-20',
            'id_usuario' => 1,
        ]);

        $response = $this->get(route('admin.detallesCompras.index', ['id_compra' => $compra->id_compra]));

        $response = $this->post(route('admin.detallesCompras.store', ['id_compra' => $compra->id_compra]), [
            'id_compra' => $compra->id_compra,
            'id_producto' => 1,
            'cantidad_producto' => 10,
            'precio_unitario' => 50.00,
            'fecha_vencimiento' => '2025-06-20',
        ]);

        $response->assertStatus(302);
        $response = $this->get(route('admin.detallesCompras.index', ['id_compra' => $compra->id_compra]));
    }
    public function test_editar_DetalleCompra()
    {
        $usuario = $this->loginUsuario();

        $compra = Compra::create([
            'id_proveedor' => 1,
            'fecha_compra' => '2024-06-20',
            'id_usuario' => 1,
        ]);

        $detalleCompra = DetalleCompra::create([
            'id_compra' => $compra->id_compra,
            'id_producto' => 1,
            'cantidad_producto' => 10,
            'precio_unitario' => 50.00,
            'fecha_vencimiento' => '2025-06-20',
        ]);

        $response = $this->put(
            route('admin.detallesCompras.update', [
                'id_compra' => $compra->id_compra,
                'detalleCompra' => $detalleCompra->id_detalle_compra,
            ]),
            [
                'id_compra' => $compra->id_compra,
                'id_producto' => 1,
                'cantidad_producto' => 20,
                'precio_unitario' => 60,
                'fecha_vencimiento' => '2025-06-20',
            ]
        );

        $response->assertStatus(302);
        $response->assertSessionHas('message', [
            'type' => 'success',
            'text' => 'El detalle de compra se ha modificado correctamente y el inventario actualizado.'
        ]);
        $this->assertDatabaseHas('detalle_compra', [
            'id_detalle_compra' => $detalleCompra->id_detalle_compra,
            'id_compra' => $compra->id_compra,
            'id_producto' => 1,
            'cantidad_producto' => 20,
            'precio_unitario' => 60,
            'fecha_vencimiento' => '2025-06-20',
        ]);
    }

    public function test_eliminar_DetalleCompra()
    {
        $usuario = $this->loginUsuario();

        $compra = Compra::create([
            'id_proveedor' => 1,
            'fecha_compra' => '2024-06-20',
            'id_usuario' => 1,
        ]);

        $detalleCompra = DetalleCompra::create([
            'id_compra' => $compra->id_compra,
            'id_producto' => 1,
            'cantidad_producto' => 10,
            'precio_unitario' => '50.00',
            'fecha_vencimiento' => '2025-06-20',
        ]);

        $detalleInventario = DetalleInventario::create([
            'id_inventario' => 1,
            'id_detalle_compra' => $detalleCompra->id_detalle_compra,
            'stock_lote' => 10, // Igual a cantidad_producto
        ]);

        $response = $this->delete(route('admin.detallesCompras.destroy', [
            'detalle' => $detalleCompra->id_detalle_compra,
        ]));


        $response->assertStatus(302);

        $this->assertDatabaseMissing('detalle_compra', [
            'id_detalle_compra' => $detalleCompra->id_detalle_compra,
        ]);
    }
}
