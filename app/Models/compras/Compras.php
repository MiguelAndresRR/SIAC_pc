<?php

namespace App\Models\compras;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\proveedor\Proveedor;
use App\Models\usuarios\User;

class Compras extends Model
{
    use HasFactory;

    protected $table = 'compra';

    protected $primaryKey = 'id_compra';

    public $timestamps = false;

    protected $fillable = [
        'id_proveedor',
        'fecha_compra',
        'id_usuario'
    ];

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class, 'id_proveedor');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function detalleCompra(): HasMany
    {
        return $this->hasMany(DetalleCompra::class, 'id_compra');
    }
}