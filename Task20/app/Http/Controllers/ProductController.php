<?php

namespace App\Http\Controllers;

use App\Additional\Export;
use App\Currencies\BelarusbankClient;
use App\Http\QueryBuilders\Filter;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Jobs\UpdateCurrencies;
use App\Models\Currency;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Mail\Attachment;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view', Product::class);

        $filter = new Filter();

        $products = $filter->run($request, Product::class)
            ->orderBy($request->order ?: 'release_date')
            ->paginate(10);
        $usdRate = Currency::where('currency', 'USD')->first()->rate;

        return view('products.index', ['products' => $products, 'usdRate' => $usdRate]);
    }

    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);

        Product::create($request->validated());

        return redirect()->route('products');
    }

    public function edit(Product $product)
    {
        $this->authorize('edit', Product::class);

        return view('products.edit', ['product' => $product]);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', Product::class);

        $product->update($request->validated());

        return redirect()->route('products');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', Product::class);

        $product->delete();

        return redirect()->route('products');
    }

    public function export()
    {
        $this->authorize('export', Product::class);

        $uploaded = Export::export(Product::class);

        if ($uploaded) {
            Mail::send('emails.products', [], function($message)
            {
                $message->to(auth()->user()->email)->subject('Products');
                $message->attach(Attachment::fromPath("files/products.csv"));
            });
        }

        return redirect()->route('products');
    }
}
