<?php

namespace App\Models\ventas;

use App\Models\usuarios\User;
use App\Models\ventas\DetalleVenta;
use App\Models\clientes\Cliente;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venta extends Model
{
    protected $table = "venta";

    protected $primaryKey = "id_venta";

    public $timestamps = false;

    protected $fillable = [
        'id_cliente',
        'fecha_venta',
        'id_usuario',
        'total_venta'
    ];
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    public function detalleVenta(): HasMany
    {
        return $this->hasMany(DetalleVenta::class, 'id_venta');
    }
}
