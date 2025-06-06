<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemListaCompra extends Model
{
    use HasFactory;

    protected $table = 'itens_lista_compra';

    protected $fillable = [
        'lista_compra_id',
        'produto_id',
        'quantidade',
    ];

    // Item pertence a uma lista
    public function lista()
    {
        return $this->belongsTo(ListaDeCompra::class, 'lista_compra_id');
    }

    // Item referencia um produto
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
