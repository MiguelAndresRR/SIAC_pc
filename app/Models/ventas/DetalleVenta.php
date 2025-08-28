<?php

namespace App\Models\ventas;

use App\Models\inventario\Inventario;
use Illuminate\Database\Eloquent\Model;
use App\Models\productos\Producto;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = "detalle_venta";

    protected $primaryKey="id_detalle_venta";

    public $timestamps = false;

    protected $fillable = [
        'id_venta',
        'id_producto',
        'cantidad_venta',
        'subtotal_venta',
        'precio_unitario_venta'
    ];
    public function venta(): BelongsTo
    {
        return $this->belongsTo(Venta::class, 'id_venta');
    }
        public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
    public function inventario(): HasMany{
        return $this->hasMany(Inventario::class, 'id_detalle_venta');
    }
}
