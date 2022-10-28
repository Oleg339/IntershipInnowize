<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use App\Repositories\ProductRepository;
use App\Repositories\ServiceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    private ProductRepository $productRepository;

    private ServiceRepository $serviceRepository;

    public function __construct(ProductRepository $productRepository, ServiceRepository $serviceRepository)
    {
        $this->productRepository = $productRepository;
        $this->serviceRepository = $serviceRepository;
    }

    public function index()
    {
        return view('catalog', [
            'products' => $this->productRepository->all(),
            'services' => $this->serviceRepository->all()
        ]);
    }

    public function store(Request $request, $productId)
    {
        $product = $this->productRepository->get($productId);

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
