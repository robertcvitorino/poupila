<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AtualizarProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'required|numeric|min:0',
            'imagem' => 'nullable|string|max:255',
            'ean' => 'required|string|max:13|unique:produtos,ean',
            'categoria_id' => 'required|exists:categorias,id',
        ];
    }
}
