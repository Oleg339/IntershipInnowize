<?php

namespace App\Models;

class Order
{
    private Product $product;

    private Service $service;

    public function __construct(Product $product, Service $service = null)
    {
        $this->product = $product;

        if ($service) {
            $this->service = $service;
        }
    }

    public function getCost()
    {
        if (!isset($this->service)) {
            return $this->product->cost;
        }

        return $this->product->cost + $this->service->cost;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getService()
    {
        if (isset($this->service)) {
            return $this->service;
        }
    }
}
