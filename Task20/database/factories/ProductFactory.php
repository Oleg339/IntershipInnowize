<?php

namespace Database\Factories;

use App\Models\Product;
use Faker\Core\Number;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws \Exception
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'company' => fake()->name(),
            'release_date' => now(),
            'cost' => random_int(0,1000),
            'type' => ['Fridge','Phone','TV','Laptop'][array_rand(['Fridge','Phone','TV','Laptop'])]
        ];
    }
}
