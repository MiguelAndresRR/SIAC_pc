<?php

namespace Tests\Feature;

use App\Models\ventas\Venta;
use App\Models\compras\DetalleVenta;
use App\Models\inventario\DetalleInventario;
use App\Models\ventas\DetalleVenta as VentasDetalleVenta;
use Tests\Helpers\LoginHelper;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class VentasTest extends TestCase
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

    public function test_crear_venta()
    {
        $usuario = $this->loginUsuario();

        $response = $this->post(route('admin.ventas.store'), [
            'id_cliente' => 1,
            'fecha_venta' => '2024-06-20',
            'id_usuario' => 1,
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.ventas.index'));
    }
    public function test_editar_venta()
    {
        $usuario = $this->loginUsuario();

        $venta = Venta::create([
            'id_cliente' => 1,
            'fecha_venta' => '2024-06-20',
            'id_usuario' => $usuario->id_usuario,
        ]);

        $datosNuevos = [
            'id_cliente' => 1,
            'fecha_venta' => '2024-06-10',
            'id_usuario' => $usuario->id_usuario,
        ];

        $response = $this->put(route('admin.ventas.update', $venta->id_venta), $datosNuevos);

        $response->assertStatus(302);

        $response->assertRedirect(route('admin.ventas.index'));

        $this->assertDatabaseHas('venta', [
            'id_venta' => $venta->id_venta,
            'fecha_venta' => '2024-06-10',
            'id_usuario' => $usuario->id_usuario,

        ]);
    }
    public function test_eliminar_venta()
    {
        $usuario = $this->loginUsuario();

        $venta = Venta::create([
            'id_cliente' => 1,
            'fecha_venta' => '2024-06-20',
            'id_usuario' => $usuario->id_usuario,
        ]);

        $response = $this->delete(route('admin.ventas.destroy', $venta->id_venta));

        $response->assertStatus(302);

        $response->assertRedirect();
        $response->assertSessionHas('message.type', 'success');


        $this->assertDatabaseMissing('venta', [
            'id_venta' => $venta->id_venta,
            'fecha_venta' => '2024-06-20',
            'id_usuario' => $usuario->id_usuario,
        ]);
    }
    public function test_crear_DetalleCompra()
    {
        $usuario = $this->loginUsuario();

        $venta = Venta::create([
            'id_cliente' => 1,
            'fecha_venta' => '2024-06-20',
            'id_usuario' => $usuario->id_usuario,
        ]);

        $response = $this->get(route('admin.detallesVentas.index', ['id_venta' => $venta->id_venta]));

        $response = $this->post(route('admin.detallesVentas.store', ['id_venta' => $venta->id_venta]), [
            'id_venta' => $venta->id_venta,
            'id_producto' => 1,
            'cantidad_venta' => 10,
        ]);

        $response->assertStatus(302);
        $response = $this->get(route('admin.detallesVentas.index', ['id_venta' => $venta->id_venta]));

        $this->assertDatabaseHas('detalle_venta', [
            'id_venta' => $venta->id_venta,
            'id_producto' => 1,
            'cantidad_venta' => 10,
            'subtotal_venta' => '25000.00',
        ]);
    }
    public function test_editar_DetalleCompra()
    {
        $usuario = $this->loginUsuario();

        $venta = Venta::create([
            'id_cliente' => 1,
            'fecha_venta' => '2024-06-20',
            'id_usuario' => $usuario->id_usuario,
        ]);

        $detalleVenta = VentasDetalleVenta::create([
            'id_venta' => $venta->id_venta,
            'id_producto' => 1,
            'cantidad_venta' => 10,
            'precio_unitario_venta' => '50.00'
        ]);

        $datosNuevos = [
            'id_venta' => $venta->id_venta,
            'id_producto' => 1,
            'cantidad_venta' => 20,
            'precio_unitario_venta' => '50.00'
        ];

        $response = $this->put(
            route('admin.detallesVentas.update', [
                'id_venta' => $venta->id_venta,
                'detalleVenta' => $detalleVenta->id_detalle_venta,
            ]),
            $datosNuevos
        );

        $response->assertStatus(302);
        $response->assertSessionHas('message', [
            'type' => 'success',
            'text' => 'El detalle de la venta se ha actualizado correctamente.'
        ]);
        $this->assertDatabaseHas('detalle_venta', [
            'id_detalle_venta' => $detalleVenta->id_detalle_venta,
            'id_venta' => $venta->id_venta,
            'id_producto' => 1,
            'cantidad_venta' => 20,
            'subtotal_venta' => 1000.00,
            'precio_unitario_venta' => '50.00'
        ]);
    }

    public function test_eliminar_DetalleCompra()
    {
        $usuario = $this->loginUsuario();

        $venta = Venta::create([
            'id_cliente' => 1,
            'fecha_venta' => '2024-06-20',
            'id_usuario' => $usuario->id_usuario,
        ]);

        $detalleVenta = VentasDetalleVenta::create([
            'id_venta' => $venta->id_venta,
            'id_producto' => 1,
            'cantidad_venta' => 10,
            'precio_unitario_venta' => '50.00'
        ]);

        $response = $this->delete(route('admin.detallesVentas.destroy', [
            'id_detalle_venta' => $detalleVenta->id_detalle_venta,
        ]));


        $response->assertStatus(302);

        $this->assertDatabaseMissing('detalle_venta', [
            'id_detalle_venta' => $detalleVenta->id_detalle_venta,
        ]);
    }
}
