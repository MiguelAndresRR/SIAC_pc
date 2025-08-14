<?php

namespace App\Models\productos;

use App\Models\compras\DetalleCompra;
use Illuminate\Database\Eloquent\Model;
use App\Models\productos\Categoria;
use App\Models\productos\Unidad;
use App\Models\inventario\Inventario;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Producto extends Model
{
    use HasFactory;

    protected $table = 'producto';

    public $timestamps = false;

    protected $primaryKey = 'id_producto';

    protected $fillable = [
        'id_categoria_producto',
        'nombre_producto',
        'precio_producto',
        'id_unidad_peso_producto'
    ];
    public function unidad()
    {
        return $this->belongsTo(Unidad::class, 'id_unidad_peso_producto');
    }
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria_producto');
    }
    public function detalleCompra(): HasMany
    {
        return $this->hasMany(DetalleCompra::class, 'id_producto');
    }
    public function inventario(): HasMany
    {
        return $this->hasMany(Inventario::class, 'id_producto');
    }
}
