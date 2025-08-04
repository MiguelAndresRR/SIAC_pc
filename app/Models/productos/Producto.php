<?php

namespace App\Models\productos;

use Illuminate\Database\Eloquent\Model;
use App\Models\productos\Categoria;
use App\Models\productos\Unidad;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    
}
