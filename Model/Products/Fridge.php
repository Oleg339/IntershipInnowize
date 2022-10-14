<?php

namespace Model\Products;

use Model\ProductAbstract;

class Fridge extends ProductAbstract
{
    const PRODUCT = 'Fridge';

    public function getProduct()
    {
        return self::PRODUCT;
    }
}