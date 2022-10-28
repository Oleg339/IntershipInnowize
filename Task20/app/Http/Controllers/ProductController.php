<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index', ['products' => Product::all(), 'types' => Product::CHILDS]);
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

        $class = 'App\Models\Products\\' . $request->type;

        $class::create([
            'name' => $request->name,
            'cost' => $request->cost,
            'release_date' => $request->release_date,
            'company' => $request->company
        ]);

        return redirect()->route('products');
    }

    public function edit(Product $product)
    {
        return view('products.edit', ['product' => $product]);
    }

    public function update(Request $request, Product $product)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'cost' => 'required|integer|min:0',
            'release_date' => 'required|date',
            'company' => 'required|max:255'
        ]);

        $class = $product::class;

        $class::where('id', $product->id)->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'release_date' => $request->release_date,
            'company' => $request->company
        ]);

        return redirect()->route('products');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products');
    }
}
