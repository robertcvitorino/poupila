<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->word(),
            'descricao' => $this->faker->sentence(),
            'preco' => $this->faker->randomFloat(2, 1, 100),
            'imagem' => $this->faker->imageUrl(300, 300, 'food', true),
            'ean' => $this->faker->unique()->ean13(),
            'categoria_id' => fake()->numberBetween(1, Categoria::count()),
        ];
    }
}
