<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\models\productos\Producto;
use App\models\compras\DetalleCompra;
use App\models\ventas\DetalleVenta;

class Inventario extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_inventario';

    public $timestamps = false;

    protected $table = "inventario";
    protected $filtable = [
        'id_producto',
        'id_detalle_compra',
        'id_detalle_venta',
        'stock'
    ];
    
    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class, 'id_producto');
    }
    public function detalleCompra(): BelongsTo
    {
        return $this->belongsTo(DetalleCompra::class, 'id_detalle_compra');
    }
        public function detalleVenta(): BelongsTo
    {
        return $this->belongsTo(DetalleVenta::class, 'id_detalle_venta');
    }
}
