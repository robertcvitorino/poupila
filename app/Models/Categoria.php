<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nome',
        'descricao',
    ];

    // Relacionamento com Produto (um para muitos)
    public function produtos()
    {
        return $this->hasMany(Produto::class);
    }
}
