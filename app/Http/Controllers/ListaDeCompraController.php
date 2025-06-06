<?php

namespace App\Http\Controllers;

use App\Http\Requests\AtualizarListaCompraRequest;
use App\Http\Requests\CriarListaCompraRequest;
use App\Models\ListaDeCompra;
use Illuminate\Http\Request;

class ListaDeCompraController extends Controller
{
    // Listar listas do usuário autenticado
    public function index()
    {
        $usuario = auth()->user();
        return $usuario->listasDeCompras()->with('produtos')->get();
    }

    // Mostrar uma lista específica do usuário autenticado
    public function show($id)
    {
        $usuario = auth()->user();
        $lista = $usuario->listasDeCompras()->with('produtos')->findOrFail($id);
        return $lista;
    }

    // Criar nova lista
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
        ]);
        $usuario = auth()->user();
        $lista = $usuario->listasDeCompras()->create($request->all());
        return response()->json($lista, 201);
    }

    // Atualizar lista
    public function update(Request $request, $id)
    {
        $usuario = auth()->user();
        $lista = $usuario->listasDeCompras()->findOrFail($id);
        $lista->update($request->all());
        return response()->json($lista);
    }

    // Deletar lista
    public function destroy($id)
    {
        $usuario = auth()->user();
        $lista = $usuario->listasDeCompras()->findOrFail($id);
        $lista->delete();
        return response()->json(['mensagem' => 'Lista deletada com sucesso']);
    }

    // Adicionar produto à lista
    public function adicionarProduto(Request $request, $id)
    {
        $request->validate([
            'produto_id' => 'required|exists:produtos,id',
            'quantidade' => 'required|integer|min:1',
        ]);
        $usuario = auth()->user();
        $lista = $usuario->listasDeCompras()->findOrFail($id);

        // Evitar duplicidade
        if ($lista->produtos()->where('produto_id', $request->produto_id)->exists()) {
            return response()->json(['mensagem' => 'Produto já está na lista'], 409);
        }

        $lista->produtos()->attach($request->produto_id, [
            'quantidade' => $request->quantidade,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return response()->json(['mensagem' => 'Produto adicionado à lista']);
    }

    // Remover produto da lista
    public function removerProduto($id, $produto_id)
    {
        $usuario = auth()->user();
        $lista = $usuario->listasDeCompras()->findOrFail($id);
        $lista->produtos()->detach($produto_id);
        return response()->json(['mensagem' => 'Produto removido da lista']);
    }
}
