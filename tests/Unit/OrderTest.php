<?php

namespace Tests\Unit;

use App\Models\Order;
use App\Models\Product;
use App\Models\Service;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class OrderTest extends TestCase
{
    public function testNewOrder()
    {
        $service = Service::factory()->create();
        $product = Product::factory()->create();

        $this->assertTrue((bool)new Order($product, $service));
    }

    public function testNewOrderWithoutService()
    {
        $product = Product::factory()->create();

        $this->assertTrue((bool)new Order($product));
    }

    public function testNewOrderTotalCost()
    {
        $product = Product::factory()->create();
        $service = Service::factory()->create();

        $order = new Order($product, $service);

        $this->assertEquals($product->cost + $service->cost, $order->getCost());
    }

    public function testNewOrderTotalCostWithoutService()
    {
        $product = Product::factory()->create();

        $order = new Order($product);

        $this->assertEquals($product->cost, $order->getCost());
    }
}
