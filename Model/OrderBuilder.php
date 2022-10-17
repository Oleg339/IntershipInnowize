<?php

namespace Model;

require_once 'vendor/autoload.php';

class OrderBuilder
{
    private Order $order;

    private ?Service $service = null;

    private Product $product;

    public function setService(Service $service): OrderBuilder
    {
        $this->service = $service;

        return $this;
    }

    public function setProduct(Product $product): OrderBuilder
    {
        $this->product = $product;

        return $this;
    }

    public function build(): OrderBuilder
    {
        $this->order = new Order($this->product, $this->service);

        return $this;
    }

    public function get(): Order
    {
        return $this->order;
    }
}