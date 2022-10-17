<?php

namespace Model;

require_once 'vendor/autoload.php';

class Order
{
    private Product $product;

    private ?Service $service;

    public function __construct(Product $product, Service $service = null)
    {
        $this->product = $product;
        $this->service = $service;
    }

    public function getProduct()
    {
        return $this->product;
    }

    public function getService()
    {
        return $this->service;
    }

    public function getTotalCost()
    {
        return intval($this->product->getCost()) + intval($this->service ? $this->service->getCost() : 0);
    }
}