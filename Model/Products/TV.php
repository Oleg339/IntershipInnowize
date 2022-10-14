<?php

namespace Model\Products;

use Model\ProductAbstract;

class TV extends ProductAbstract
{
    const PRODUCT = 'TV';

    public function getProduct()
    {
        return self::PRODUCT;
    }
}