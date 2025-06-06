<?php

namespace Database\Seeders;

use Database\Factories\ItemListaDeCompraFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemListaDeCompraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemListaDeCompraFactory::new()->count(10)->create();
    }
}
