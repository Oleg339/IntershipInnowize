<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class ProductFactory
{
    public function create(array $request)
    {
        $class = 'App\Models\Products\\' . $request['type'];

        return $class::create([
            'name' => $request['name'],
            'cost' => $request['cost'],
            'release_date' => $request['release_date'],
            'company' => $request['company']
        ]);
    }

    public function all()
    {
        $data = DB::table('products')->get();

        $products = collect();

        foreach ($data as $item) {
            $products->push($item->type::where('id', $item->id)->get()[0]);
        }

        return $products;
    }
}
