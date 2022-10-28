<?php

namespace App\Repositories;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    public function all()
    {
        $data = DB::table('products')->get();

        $products = collect();

        foreach ($data as $item) {
            $products->push($item->type::where('id', $item->id)->get()[0]);
        }

        return $products;
    }

    public function get($id)
    {
        return DB::table('products')->where('id', $id)->get()[0]
            ->type::where('id', $id)->get()[0];
    }

    public function delete($id)
    {
        return self::get($id)->delete();
    }

    public function getClass($id)
    {
        return DB::table('products')->where('id', $id)->get()->first()->type;
    }

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

    public function update(array $request, $productId)
    {
        return $this->getClass($productId)::where('id', $productId)->update([
            'name' => $request['name'],
            'cost' => $request['cost'],
            'release_date' => $request['release_date'],
            'company' => $request['company']
        ]);
    }
}
