<?php

namespace Database\Seeders;

use App\Models\ListaDeCompra;
use App\Models\Produto;
use App\Models\Usuario;
use Database\Factories\ListaDeCompraFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ListaCompraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuarios = Usuario::all();
        $produtos = Produto::all();

        if ($usuarios->isEmpty()) {
            $this->command->warn('Nenhum usuário encontrado. Execute o UsuarioSeeder primeiro.');
            return;
        }

        if ($produtos->isEmpty()) {
            $this->command->warn('Nenhum produto encontrado. Execute o ProdutoSeeder primeiro.');
            return;
        }

        // Criar listas para cada usuário
        foreach ($usuarios->take(5) as $usuario) {
            // Criar 3 listas por usuário
            for ($i = 1; $i <= 3; $i++) {
                $lista = ListaDeCompra::create([
                    'nome' => "Lista de Compras {$i} - {$usuario->nome}",
                    'descricao' => "Lista criada para {$usuario->nome}",
                    'usuario_id' => $usuario->id,
                ]);

                // Adicionar produtos na lista
                $this->adicionarProdutosNaLista($lista, $produtos);
            }
        }
    }

    /**
     * Adiciona produtos aleatórios na lista
     */
    private function adicionarProdutosNaLista(ListaDeCompra $lista, $produtos)
    {
        // Selecionar entre 3 a 8 produtos aleatórios
        $quantidadeProdutos = rand(3, 8);
        $produtosSelecionados = $produtos->random($quantidadeProdutos);

        foreach ($produtosSelecionados as $produto) {
            // Verificar se o produto já não está na lista (evitar duplicatas)
            if (!$lista->produtos()->where('produto_id', $produto->id)->exists()) {
                $lista->produtos()->attach($produto->id, [
                    'quantidade' => rand(1, 5),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info("Lista '{$lista->nome}' populada com {$produtosSelecionados->count()} produtos.");
    }
}
