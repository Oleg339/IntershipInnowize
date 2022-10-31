<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            return view('confirmation', ['order' => new Order($product)]);
        }

        $service = Service::where('id', $serviceId)->get()->first();

        return view('confirmation', ['order' => new Order($product, $service)]);
    }
}
