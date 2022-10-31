<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private Repository $productRepository;

    public function __construct()
    {
        $this->productRepository = new Repository(Product::class);
    }

    public function index()
    {
        return view('products.index', ['products' => $this->productRepository->all(), 'types' => Product::PRODUCTS]);
    }

    public function store(StoreProductRequest $request)
    {
        $this->productRepository->create($request->validated());

        return redirect()->route('products');
    }

    public function edit(Product $product)
    {
        return view('products.edit', ['product' => $product]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->productRepository->update($request->validated(), $product);

        return redirect()->route('products');
    }

    public function destroy(Product $product)
    {
        $this->productRepository->delete($product);

        return redirect()->route('products');
    }
}
