<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => fake()->name(),
            'company' => fake()->unique()->safeEmail(),
            'release_date' => now(),
            'cost' => random_int(0,1000),
            'type' => 'App\\Models\\Products\\' . Product::PRODUCTS[array_rand(Product::PRODUCTS)]
        ]);
    }
}
