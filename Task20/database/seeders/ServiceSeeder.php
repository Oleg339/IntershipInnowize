<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            'cost' => fake()->name(),
            'deadline' => fake()->unique()->safeEmail(),
            'type' => 'App\Models\Product' . array_rand(Service::SERVICES)
        ]);
    }
}
