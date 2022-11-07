<?php

namespace App\Http\Controllers;

use App\Http\QueryBuilders\Filter;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $filter = new Filter();

        $products = $filter->run($request, Product::class)
            ->orderBy($request->order ?: 'release_date')
            ->paginate(10);

        $services = Service::all();

        $usd = Currency::where('currency', 'usd')->first()->rate;

        return view('catalog', ['products' => $products, 'services' => $services, 'usd' => $usd]);
    }

    public function store(Request $request)
    {
        $productId = $request->productId;
        $serviceId = $request->serviceId;

        $product = Product::where('id', $productId)->get()->first();

        if ($serviceId === "none") {
            $order = new Order($product);
            return view('confirmation', ['order' => $order]);
        }

        $service = Service::where('id', $serviceId)->get()->first();
        $order = new Order($product, $service);

        return view('confirmation', ['order' => $order]);
    }
}
