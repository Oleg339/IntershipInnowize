<?php

namespace App\Http\Controllers;

use App\Http\QueryBuilders\Filter;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filter = new Filter();

        $products = $filter->run($request, Product::class)
            ->orderBy($request->order ?: 'release_date')
            ->paginate(10);

        return view('products.index', ['products' => $products]);
    }

    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('products');
    }

    public function edit(Product $product)
    {
        return view('products.edit', ['product' => $product]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return redirect()->route('products');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products');
    }

    public function import()
    {

    }
}
