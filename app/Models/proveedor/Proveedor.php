<?php

namespace App\Models\proveedor;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\compras\Compra;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedor';

    protected $primaryKey = 'id_proveedor';

    public $timestamps = false;

    protected $fillable = [
        'nombre_proveedor',
        'nit_proveedor',
        'direccion_proveedor',
        'telefono_proveedor',
        'correo_proveedor'
    ];

    public function compra(): HasMany
    {
        return $this->hasMany(Compra::class, 'id_proveedor');
    }
}
