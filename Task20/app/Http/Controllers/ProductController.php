<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\ProductFactory;
use App\Repositories\ProductRepository;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private ProductFactory $productFactory;

    public function __construct()
    {
        $this->productFactory = new ProductFactory();
    }

    public function index()
    {
        return view('products.index', ['products' => $this->productFactory->all(), 'types' => Product::PRODUCTS]);
    }

    public function store(StoreProductRequest $request)
    {
        $product =  $request->validated();

        $this->productFactory->create($product);

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
}
