<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListaDeCompra extends Model
{
    use HasFactory;

    protected $table = 'listas_de_compras';

    protected $fillable = [
        'nome',
        'usuario_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'itens_lista_de_compras')
            ->withPivot('quantidade')
            ->withTimestamps();
    }
}
