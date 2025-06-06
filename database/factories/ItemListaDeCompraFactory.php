<?php

namespace Database\Factories;

use App\Models\ListaDeCompra;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ItemListaDeCompraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lista_de_compra_id' => fake()->numberBetween(1, ListaDeCompra::count()),
            'produto_id' => fake()->numberBetween(1, Produto::count()),
            'quantidade' => fake()->numberBetween(1, 5),
        ];
    }
}
