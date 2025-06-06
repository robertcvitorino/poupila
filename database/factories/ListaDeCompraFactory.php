<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ListaDeCompra>
 */
class ListaDeCompraFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => fake()->sentence(3),
            'descricao' => fake()->paragraph(),
            'usuario_id' => fake()->numberBetween( 1,Usuario::count()),
        ];
    }
}
