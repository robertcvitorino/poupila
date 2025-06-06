<?php

namespace Database\Seeders;

use Database\Factories\ProdutoFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        ProdutoFactory::new()->count(10)->create();
    }
}
