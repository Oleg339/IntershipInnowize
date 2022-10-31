<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductFactory;
use App\Models\Service;
use App\Models\ServiceFactory;
use App\Repositories\ProductRepository;
use App\Repositories\Repository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private ProductFactory $productFactory;

    private ServiceFactory $serviceFactory;

    public function __construct()
    {
        $this->productFactory = new ProductFactory;
        $this->serviceFactory = new ServiceFactory;
    }

    public function index()
    {
        return view('catalog', [
            'products' => $this->productFactory->all(),
            'services' => $this->serviceFactory->all()
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
                Service::get('id', $serviceId)->first()
            )
            ]
        );
    }
}
