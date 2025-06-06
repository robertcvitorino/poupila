<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CriarProdutoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    public function rules(): array
    {
        return [
            'nome' => 'sometimes|required|string|max:255',
            'descricao' => 'nullable|string',
            'preco' => 'sometimes|required|numeric|min:0',
            'imagem' => 'nullable|string|max:255',
            'ean' => 'sometimes|required|string|max:13|unique:produtos,ean,' . $this->route('produto'),
            'categoria_id' => 'sometimes|required|exists:categorias,id',
        ];
    }
}
