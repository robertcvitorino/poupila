<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtualizarProdutoRequest;
use App\Http\Requests\CriarProdutoRequest;
use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    public function index()
    {
        return Produto::with('categoria')->get();
    }

    public function show($id)
    {
        return Produto::with('categoria')->findOrFail($id);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric',
            'imagem' => 'nullable|string',
            'codigo_ean' => 'required|string|unique:produtos,codigo_ean',
            'categoria_id' => 'required|exists:categorias,id',
        ]);
        $produto = Produto::create($request->all());
        return response()->json($produto, 201);
    }

    public function update(Request $request, $id)
    {
        $produto = Produto::findOrFail($id);
        $produto->update($request->all());
        return response()->json($produto);
    }

    public function destroy($id)
    {
        $produto = Produto::findOrFail($id);
        $produto->delete();
        return response()->json(['mensagem' => 'Produto deletado com sucesso']);
    }

    // Procurar produto pelo código EAN
    public function buscarPorEan($codigo_ean)
    {
        $produto = Produto::where('ean', $codigo_ean)->first();

        if (!$produto) {
            return response()->json(['mensagem' => 'Produto não encontrado com este código EAN'], 404);
        }

        return response()->json($produto);
    }

    // Procurar produtos pelo nome (busca parcial)
    public function buscarPorNome( $nome)
    {

        if (!$nome) {
            return response()->json(['mensagem' => 'O parâmetro "nome" é obrigatório'], 400);
        }

        $produtos = Produto::where('nome', 'like', '%' . $nome . '%')->get();

        if ($produtos->isEmpty()) {
            return response()->json(['mensagem' => 'Nenhum produto encontrado com este nome'], 404);
        }

        return response()->json($produtos);
    }
}
