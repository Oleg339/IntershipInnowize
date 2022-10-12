<?php

namespace Model\Products;

use ProductAbstract;

class Laptop extends ProductAbstract
{
    const PRODUCT = 'Laptop';

    public function getProduct()
    {
        return self::PRODUCT;
    }
}