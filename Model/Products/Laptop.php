<?php

namespace Model\Products;

use Model\ProductAbstract;

class Laptop extends ProductAbstract
{
    const PRODUCT = 'Laptop';

    public function getProduct()
    {
        return self::PRODUCT;
    }
}