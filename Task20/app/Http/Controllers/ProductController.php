<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $data = DB::table('products')->get();

        $products = collect();

        foreach ($data as $item) {
            $products->push($item->type::where('id', $item->id)->get()[0]);
        }

        return view('products.index', ['products' => $products, 'types' => Product::CHILDS]);
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

    public function edit($product)
    {
        $product = DB::table('products')->where('id', $product)->get()[0]
        ->type::where('id', $product)->get()[0];

        return view('products.edit', ['product' => $product]);
    }

    public function update(Request $request, $product)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'cost' => 'required|integer|min:0',
            'release_date' => 'required|date',
            'company' => 'required|max:255'
        ]);

        $class = DB::table('products')->where('id', $product)->get()->first()->type;

        $class::where('id', $product)->update([
            'name' => $request->name,
            'cost' => $request->cost,
            'release_date' => $request->release_date,
            'company' => $request->company
        ]);

        return redirect()->route('products');
    }

    public function destroy($product)
    {
        DB::table('products')->where('id', $product)->get()->first()
            ->type::where('id', $product)->get()[0]->delete();

        return redirect()->route('products');
    }
}
