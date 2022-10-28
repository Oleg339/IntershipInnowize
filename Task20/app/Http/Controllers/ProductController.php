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

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'cost' => 'required|integer|min:0',
            'release_date' => 'required|date',
            'company' => 'required|max:255',
            'type' => 'in:Fridge,Phone,TV,Laptop'
        ]);

        $this->productRepository->create($request);

        return redirect()->route('products');
    }

    public function edit($productId)
    {
        return view('products.edit', ['product' => $this->productRepository->get($productId)]);
    }

    public function update(Request $request, $productId)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'cost' => 'required|integer|min:0',
            'release_date' => 'required|date',
            'company' => 'required|max:255'
        ]);

        $this->productRepository->update($request, $productId);

        return redirect()->route('products');
    }

    public function destroy($productId)
    {
        $this->productRepository->delete($productId);

        return redirect()->route('products');
    }
}
