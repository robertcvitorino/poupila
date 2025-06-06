<?php

namespace Database\Seeders;

use Database\Factories\UsuarioFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UsuarioFactory::new()->count(10)->create();
    }
}
