<?php

namespace App\Models\compras;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\compras\Compra;
use App\Models\productos\Producto;
use App\Models\inventario\Inventario;

class DetalleCompra extends Model
{
    protected $table = 'detalle_compra';
    protected $primaryKey = 'id_detalle_compra';

    public $timestamps = false;

    protected $fillable = [
        'id_compra',
        'id_producto',
        'cantidad_producto',
        'precio_unitario',
        'subtotal_compra',
        'total_compra',
        'fecha_vencimiento'
    ];

    public function compra(): BelongsTo
    {
        return $this->belongsTo(Compra::class, 'id_compra');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
    public function inventario()
    {
        return $this->hasMany(Inventario::class, 'id_detalle_compra');
    }
}
