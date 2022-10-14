<?php

namespace Model\Products;

use Model\ProductAbstract;

class Phone extends ProductAbstract
{
    const PRODUCT = 'Phone';

    public function getProduct()
    {
        return self::PRODUCT;
    }
}