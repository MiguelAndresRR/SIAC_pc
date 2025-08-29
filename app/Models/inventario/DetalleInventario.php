<?php

namespace App\Models\inventario;

use Illuminate\Database\Eloquent\Model;
use App\Models\compras\DetalleCompra;
use App\Models\inventario\Inventario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class DetalleInventario extends Model
{
    protected $table = 'detalle_inventario';

    protected $primaryKey = 'id_detalle_inventario';

    public $timestamps = false;

    protected $fillable = [
        'id_inventario',
        'id_detalle_compra',
        'stock_lote'
    ];
    public function inventario(): BelongsTo
    {
        return $this->belongsTo(Inventario::class, 'id_inventario');
    }
    public function detalleCompra(): BelongsTo
    {
        return $this->belongsTo(DetalleCompra::class, 'id_detalle_compra');
    }
}
