<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
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

    public function edit($productId)
    {
        return view('products.edit', ['product' => $this->productRepository->get($productId)]);
    }

    public function update(UpdateProductRequest $request, $productId)
    {
        $this->productRepository->update($request->validated(), $productId);

        return redirect()->route('products');
    }

    public function destroy($productId)
    {
        $this->productRepository->delete($productId);

        return redirect()->route('products');
    }
}
