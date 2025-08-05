<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\compras\DetalleCompra;
use App\Models\compras\Compras;

class ComprasController extends Controller
{
    public function index(Request $request)
    {
    }
    public function show(Compras $compra)
    {
    }

    public function edit(Compras $compra)
    {
    }

    public function update(Request $request, Compras $compra)
    {
    }

    public function destroy($id_compra)
    {
    }
}
class DetallesCompraController extends Controller
{
    public function index(Request $request)
    {
    }
    public function show(DetalleCompra $detalleCompra)
    {
    }

    public function edit(DetalleCompra $compra)
    {
    }

    public function update(Request $request, DetalleCompra $compra)
    {
    }

    public function destroy($id_detalle_compra)
    {
    }
}