<?php

namespace App\Models\clientes;

use App\Models\ventas\Venta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';

    protected $primaryKey = 'id_cliente';

    public $timestamps = false;

    protected $fillable = [
        'nombre_cliente',
        'apellido_cliente',
        'documento_cliente',
        'telefono_cliente',
        'direccion_cliente',
        'correo_cliente'
    ];
    public function ventas(): hasMany{
        return $this->hasMany(Venta::class, 'id_cliente');
    }
}
