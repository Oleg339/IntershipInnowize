<?php

require_once 'vendor/autoload.php';

use Model\OrderBuilder;
use Model\Products\PhoneBuilder;
use Model\Services\WarrantyBuilder;

$phone = (new PhoneBuilder())->setName('IPhone 16S')->setCost('50$')->setDate('12.02.2003')->setManufacture('Apple')->build()->get();

$warranty = (New WarrantyBuilder())->setCost('12$')->setDeadline('13.09.2004')->build()->get();

$order = (New OrderBuilder())->setProduct($phone)->setService($warranty)->build()->get();

echo $order->getService()->getCost() . '<br>' .
     $order->getProduct()->getName() . '<br>' .
     $order->getTotalCost() . '$';

