<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'type' => 'App\\Models\\Services\\' . array_rand(Service::SERVICES)
        ]);
    }
}
