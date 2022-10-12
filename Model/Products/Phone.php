<?php

namespace Model\Products;

use ProductAbstract;

class Phone extends ProductAbstract
{
    const PRODUCT = 'Phone';

    public function getProduct()
    {
        return self::PRODUCT;
    }
}