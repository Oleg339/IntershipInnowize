<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $services = Service::all();

        return view('catalog', ['products' => $products, 'services' => $services]);
    }

    public function store(Request $request, Product $product)
    {
        $serviceId = $request->serviceId;

        if ($serviceId === "none") {
            $product = new Order($product);
            return view('confirmation', ['order' => $product]);
        }

        $service = Service::where('id', $serviceId)->get()->first();
        $order = new Order($product, $service);

        return view('confirmation', ['order' => $order]);
    }
}
