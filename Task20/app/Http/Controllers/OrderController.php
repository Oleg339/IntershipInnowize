<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Repositories\ProductRepository;
use App\Repositories\Repository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private Repository $productRepository;

    private Repository $serviceRepository;

    public function __construct()
    {
        $this->productRepository = new Repository(Product::class);
        $this->serviceRepository = new Repository(Service::class);
    }

    public function index()
    {
        return view('catalog', [
            'products' => $this->productRepository->all(),
            'services' => $this->serviceRepository->all()
        ]);
    }

    public function store(Request $request, Product $product)
    {
        $serviceId = $request->serviceId;

        if ($serviceId === "none") {
            return view('confirmation', ['order' => new Order($product)]);
        }

        return view('confirmation',
            ['order' => new Order(
                $product,
                $this->serviceRepository->get($serviceId)
            )
            ]
        );
    }
}
