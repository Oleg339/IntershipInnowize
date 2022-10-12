<?php

namespace Model\Products;

use ProductAbstract;

class Fridge extends ProductAbstract
{
    const PRODUCT = 'Fridge';

    public function getProduct()
    {
        return self::PRODUCT;
    }
}