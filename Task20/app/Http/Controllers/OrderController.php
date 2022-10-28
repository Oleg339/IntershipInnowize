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
        $dataProducts = DB::table('products')->get();
        $dataServices = DB::table('services')->get();

        $products = collect();
        $services = collect();

        foreach ($dataProducts as $item) {
            $products->push($item->type::where('id', $item->id)->get()->first());
        }

        foreach ($dataServices as $item) {
            $services->push($item->type::where('id', $item->id)->get()->first());
        }

        return view('catalog', ['products' => $products, 'services' => $services]);
    }

    public function store(Request $request, $product)
    {
        $product = DB::table('products')->where('id', $product)->get()->first()
            ->type::where('id', $product)->get()->first();

        $service = $request->serviceId;
        $service = DB::table('services')->where('id', $service)->get()->first()
            ->type::where('id', $service)->get()->first();

        $order = new Order($product, $service);

        dd($order);
    }
}
