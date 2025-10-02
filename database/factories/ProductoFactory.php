<?php

namespace Database\Factories;

use App\Models\productos\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    protected $model = Producto::class;

    public function definition(): array
    {
        return [
            'nombre_producto' => $this->faker->word(),
            'precio_producto' => $this->faker->randomFloat(2, 100, 1000),
            'id_unidad_peso_producto' => 1,
            'id_categoria_producto' => 1, 
        ];
    }
}
