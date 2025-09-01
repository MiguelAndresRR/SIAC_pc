<?php

namespace App\Http\Controllers;

use App\Models\productos\Producto;
use App\Models\ventas\Venta;
use App\Models\compras\Compra;
use App\Models\inventario\Inventario;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ventas por mes (últimos 6 meses)
        $ventasPorMes = Venta::select(
            DB::raw('MONTH(fecha_venta) as mes'),
            DB::raw('COUNT(*) as total')
        )
            ->groupBy('mes')
            ->orderBy('mes')
            ->pluck('total', 'mes');

        return view('admin.dashboard', [
            'ventasPorMes' => $ventasPorMes
        ]);
    }
}
