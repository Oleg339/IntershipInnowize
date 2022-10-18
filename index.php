<?php

require_once 'vendor/autoload.php';

use Model\OrderBuilder;
use Model\Products\Phone;
use Model\Products\ProductBuilder;
use Model\Services\Delivery;
use Model\Services\ServiceBuilder;

$phone = (new ProductBuilder(Phone::class))->setName('IPhone 16S')->setCost('50$')->setDate('12.02.2003')->setManufacture('Apple')->build()->get();

$delivery = (new ServiceBuilder(Delivery::class))->setDeadline('12$')->setCost('90')->build()->get();

$order = (New OrderBuilder())->setProduct($phone)->setService($delivery)->build()->get();

echo $order->getService()->getCost() . '<br>' .
     $order->getProduct()->getName() . '<br>' .
     $order->getTotalCost() . '$';

