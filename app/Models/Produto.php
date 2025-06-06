<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'imagem',
        'ean',
        'categoria_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function listasDeCompras()
    {
        return $this->belongsToMany(ListaDeCompra::class, 'itens_lista_de_compras')
            ->withPivot('quantidade')
            ->withTimestamps();
    }
}
