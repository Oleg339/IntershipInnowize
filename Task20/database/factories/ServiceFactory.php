<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'deadline' => now(),
            'cost' => random_int(0,1000),
            'type' => ['Fridge','Phone','TV','Laptop'][array_rand(['Configure','Delivery','Install','Warranty'])]
        ];
    }
}
