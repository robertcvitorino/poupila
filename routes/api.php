<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ListaDeCompraController;
use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;


Route::post('/registrar', [AuthController::class, 'registrar']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/refresh-token', [AuthController::class, 'refreshToken']);


Route::middleware('auth:sanctum')->group(function () {
    //Route::apiResource('usuarios', UsuarioController::class)->except(['store']);
    Route::apiResource('categorias', CategoriaController::class);
    Route::apiResource('produtos', ProdutoController::class);
    Route::get('/produtos/ean/{codigo_ean}', [ProdutoController::class, 'buscarPorEan']);
    Route::get('/produtos/nome/{nome}', [ProdutoController::class, 'buscarPorNome']);
    Route::apiResource('listas', ListaDeCompraController::class);

    // Rotas extras para lista de compras
    Route::post('listas/{id}/adicionar-produto', [ListaDeCompraController::class, 'adicionarProduto']);
    Route::delete('listas/{id}/remover-produto/{produto_id}', [ListaDeCompraController::class, 'removerProduto']);
});
