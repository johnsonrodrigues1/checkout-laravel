<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;


class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        Product::create([
            'name' => 'Produto Teste - Simulação',
            'description' => 'Este é um produto de teste para simulação.',
            'price' => $faker->randomFloat(2, 10, 500)
        ]);
    }
}
